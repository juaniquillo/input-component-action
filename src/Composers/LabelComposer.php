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
use Juaniquillo\InputComponentAction\Contracts\LabelTheme;
use Juaniquillo\InputComponentAction\Contracts\ValueManager;
use Juaniquillo\InputComponentAction\Recipes\InputComponentRecipe;

final class LabelComposer implements ComponentComposer
{
    use IsComposer;

    public function __construct(
        private InputInterface $input,
        private InputComponentRecipe $recipe,
        private ThemeManager $themeManager,
        private ?ValueManager $values = null,
        private ?ErrorManager $errors = null,
        private ?LabelTheme $themeBag = null,
    ) {}

    public function build(): BackendComponent|ContentComponent|ThemeComponent
    {
        $input = $this->input;
        $recipe = $this->recipe;

        $name = $input->getName();
        $label = $recipe->label ?? $input->getLabel();
        $themeManager = $recipe->themeManager ?? $this->themeManager;

        $componentType = $this->resolveLabelType($recipe);

        $label = $this->resolveStringClosure($input, $label);

        $component = new MainBackendComponent($componentType, $themeManager);

        $inputType = $this->resolveInputType($recipe);

        $attributes = $recipe->attributeBag?->getLabelAttributes();
        $theme = $recipe->themeBag?->getLabelTheme() ?? $this->themeBag?->getLabelTheme();

        $attributes = $this->resolveArrayClosure(value: $attributes, input: $input, type: $inputType);
        $themes = $this->resolveArrayClosure(value: $theme, input: $input, type: $inputType);

        if (! $recipe->emptyLabel) {
            $component->setContent($label);
        }

        if (! $recipe->disableDefaultForAttribute) {
            $component->setAttribute('for', $name);
        }

        if ($attributes) {
            $component->setAttributes($attributes);
        }

        if ($themes) {
            $component->setThemes($themes);
        }

        $callback = $recipe->hookBag ?? new DefaultHookBag;
        $component = $this->resolveComponentHook(
            component: $component,
            closure: $callback->getLabelHook(),
            input: $input,
            type: $inputType,
            values: $this->values,
            errors: $this->errors,
        );

        return $component;
    }
}
