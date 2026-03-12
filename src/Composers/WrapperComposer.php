<?php

declare(strict_types=1);

namespace Juaniquillo\InputComponentAction\Composers;

use Juaniquillo\BackendComponents\Contracts\BackendComponent;
use Juaniquillo\BackendComponents\Contracts\ContentComponent;
use Juaniquillo\BackendComponents\Contracts\ThemeComponent;
use Juaniquillo\BackendComponents\Contracts\ThemeManager;
use Juaniquillo\CrudAssistant\Contracts\InputInterface;
use Juaniquillo\InputComponentAction\Bags\DefaultHookBag;
use Juaniquillo\InputComponentAction\Concerns\IsComposer;
use Juaniquillo\InputComponentAction\Contracts\ComponentBag;
use Juaniquillo\InputComponentAction\Contracts\ComponentComposer;
use Juaniquillo\InputComponentAction\Contracts\ErrorManager;
use Juaniquillo\InputComponentAction\Contracts\ValueManager;
use Juaniquillo\InputComponentAction\Contracts\WrapperComponent;
use Juaniquillo\InputComponentAction\Contracts\WrapperTheme;
use Juaniquillo\InputComponentAction\Utilities\Support;

final class WrapperComposer implements ComponentComposer
{
    use IsComposer;

    public function __construct(
        private InputInterface $input,
        private ThemeManager $themeManager,
        private ComponentBag|WrapperComponent $componentBag,
        private ?ValueManager $values = null,
        private ?ErrorManager $errors = null,
        private ?WrapperTheme $themeBag = null,
    ) {}

    public function build(): BackendComponent|ContentComponent|ThemeComponent
    {
        $input = $this->input;
        $recipe = Support::getRecipe($input);
        $themeManager = $this->themeManager;

        $recipeComponentBag = $recipe->getComponentBag();
        $defaultComponentBag = $this->componentBag;

        $componentType = Support::resolveWrapperType($recipe, $defaultComponentBag);
        $inputType = Support::resolveInputType($recipe, $defaultComponentBag);

        $component = Support::resolveComponent(
            component: $recipeComponentBag?->getWrapperComponent() ?? $defaultComponentBag->getWrapperComponent(),
            type: $componentType,
            themeManager: $themeManager
        );

        $attributes = $recipe->getAttributeBag()?->getInputAttributes() ?? null;
        $theme = $recipe->getThemeBag()?->getWrapperTheme() ?? $this->themeBag?->getWrapperTheme();
        $callback = $recipe->getHookBag() ?? new DefaultHookBag;

        $attributes = $this->resolveArrayClosure(value: $attributes, input: $input, type: $inputType);
        $theme = $this->resolveArrayClosure($theme, input: $input, type: $inputType);

        if ($theme) {
            $component->setThemes($theme);
        }

        if ($recipe->labelAsInputContent()) {
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
