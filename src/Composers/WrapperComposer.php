<?php

declare(strict_types=1);

namespace Juaniquillo\InputComponentAction\Composers;

use Juaniquillo\BackendComponents\Contracts\BackendComponent;
use Juaniquillo\BackendComponents\Contracts\ContentComponent;
use Juaniquillo\BackendComponents\Contracts\ThemeComponent;
use Juaniquillo\BackendComponents\Contracts\ThemeManager;
use Juaniquillo\BackendComponents\MainBackendComponent;
use Juaniquillo\CrudAssistant\Contracts\InputInterface;
use Juaniquillo\InputComponentAction\Bags\DefaultHookBag;
use Juaniquillo\InputComponentAction\Concerns\IsComposer;
use Juaniquillo\InputComponentAction\Contracts\ComponentComposer;
use Juaniquillo\InputComponentAction\Contracts\ErrorManager;
use Juaniquillo\InputComponentAction\Contracts\ValueManager;
use Juaniquillo\InputComponentAction\Contracts\WrapperTheme;
use Juaniquillo\InputComponentAction\Utilities\Support;

final class WrapperComposer implements ComponentComposer
{
    use IsComposer;

    public function __construct(
        private InputInterface $input,
        private ThemeManager $themeManager,
        private ?ValueManager $values = null,
        private ?ErrorManager $errors = null,
        private ?WrapperTheme $themeBag = null,
    ) {}

    public function build(): BackendComponent|ContentComponent|ThemeComponent
    {
        $input = $this->input;
        $recipe = Support::getRecipe($input);
        $componentType = $this->resolveWrapperType($recipe);
        $themeManager = $recipe->themeManager ?? $this->themeManager;

        $component = new MainBackendComponent($componentType, $themeManager);

        $inputType = $this->resolveInputType($recipe);

        $attributes = $recipe->attributeBag?->getInputAttributes() ?? null;
        $theme = $recipe->themeBag?->getWrapperTheme() ?? $this->themeBag?->getWrapperTheme();
        $callback = $recipe->hookBag ?? new DefaultHookBag;

        $attributes = $this->resolveArrayClosure(value: $attributes, input: $input, type: $inputType);
        $theme = $this->resolveArrayClosure($theme, input: $input, type: $inputType);

        if ($theme) {
            $component->setThemes($theme);
        }

        if ($recipe->labelAsInputContent) {
            $component->setContent($input->getLabel());
        }

        $component = $this->resolveComponentHook(
            component: $component,
            closure: $callback->getWrapperHook(),
            input: $input,
            type: $inputType,
            values: $this->values,
            errors: $this->errors,
        );

        return $component;
    }
}
