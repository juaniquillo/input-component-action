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
use Juaniquillo\InputComponentAction\Contracts\ErrorManager;
use Juaniquillo\InputComponentAction\Contracts\HelpTextComponent;
use Juaniquillo\InputComponentAction\Contracts\HelpTextTheme;
use Juaniquillo\InputComponentAction\Contracts\ValueManager;
use Juaniquillo\InputComponentAction\Recipes\InputComponentRecipe;
use Juaniquillo\InputComponentAction\Utilities\Support;

class HelpTextComposer
{
    use IsComposer;

    public function __construct(
        private InputInterface $input,
        private InputComponentRecipe $recipe,
        private ThemeManager $themeManager,
        private ComponentBag|HelpTextComponent $componentBag,
        private ?ValueManager $values = null,
        private ?ErrorManager $errors = null,
        private ?HelpTextTheme $themeBag = null,
    ) {}

    public function build(): BackendComponent|ContentComponent|ThemeComponent
    {
        $input = $this->input;

        $recipe = $this->recipe;

        $helpText = $recipe->getHelpText();
        $callback = $recipe->getHookBag()?->getInputHook() ?? null;

        $attributes = $recipe->getAttributeBag()?->getHelpTextAttributes() ?? null;
        $theme = $recipe->getThemeBag()?->getHelpTextTheme() ?? $this->themeBag?->getHelpTextTheme();

        $themeManager = $this->themeManager;
        $recipeComponentBag = $recipe->getComponentBag();
        $defaultComponentBag = $this->componentBag;

        $componentType = Support::resolveHelpTextType($recipe, $defaultComponentBag);
        $inputType = Support::resolveInputType($recipe, $defaultComponentBag);

        $attributes = $this->resolveArrayClosure(value: $attributes, input: $input, type: $inputType);
        $themes = $this->resolveArrayClosure(value: $theme, input: $input, type: $inputType);
        $helpText = $this->resolveStringClosure(input: $input, stringClosure: $helpText);

        $component = Support::resolveComponent(
            component: $recipeComponentBag?->getHelpTextComponent() ?? $defaultComponentBag->getHelpTextComponent(),
            type: $componentType,
            themeManager: $themeManager
        );

        if ($attributes) {
            $component->setAttributes($attributes);
        }

        if ($themes) {
            $component->setThemes($themes);
        }

        if ($helpText) {
            $component->setContent($helpText);
        }

        $callback = $recipe->getHookBag() ?? new DefaultHookBag;
        $component = $this->resolveComponentHook(
            component: $component,
            closure: $callback->getHelpTextHook(),
            input: $input,
            type: $inputType,
            values: $this->values,
            errors: $this->errors,
        );

        return $component;
    }
}
