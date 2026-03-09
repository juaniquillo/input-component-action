<?php

declare(strict_types=1);

namespace Juaniquillo\InputComponentAction\Composers;

use Juaniquillo\BackendComponents\Contracts\BackendComponent;
use Juaniquillo\BackendComponents\Contracts\ContentComponent;
use Juaniquillo\BackendComponents\Contracts\ThemeComponent;
use Juaniquillo\BackendComponents\Contracts\ThemeManager;
use Juaniquillo\BackendComponents\Enums\ComponentEnum;
use Juaniquillo\CrudAssistant\Contracts\InputInterface;
use Juaniquillo\InputComponentAction\Bags\DefaultHookBag;
use Juaniquillo\InputComponentAction\Concerns\IsComposer;
use Juaniquillo\InputComponentAction\Contracts\ComponentBag;
use Juaniquillo\InputComponentAction\Contracts\ErrorComponent;
use Juaniquillo\InputComponentAction\Contracts\ErrorManager;
use Juaniquillo\InputComponentAction\Contracts\HelpTextComponent;
use Juaniquillo\InputComponentAction\Contracts\HelpTextTheme;
use Juaniquillo\InputComponentAction\Contracts\LabelComponent;
use Juaniquillo\InputComponentAction\Contracts\ValueManager;
use Juaniquillo\InputComponentAction\Contracts\WrapperComponent;
use Juaniquillo\InputComponentAction\Recipes\InputComponentRecipe;
use Juaniquillo\InputComponentAction\Utilities\Support;

class HelpTextComposer
{
    use IsComposer;

    public function __construct(
        private InputInterface $input,
        private InputComponentRecipe $recipe,
        private ThemeManager $themeManager,
        private ?ValueManager $values = null,
        private ?ErrorManager $errors = null,
        private ?HelpTextTheme $themeBag = null,
        private ComponentBag|WrapperComponent|LabelComponent|ErrorComponent|HelpTextComponent|null $componentBag = null,
    ) {}

    public function build(): BackendComponent|ContentComponent|ThemeComponent
    {
        $input = $this->input;

        $recipe = $this->recipe;

        $helpText = $recipe->getHelpText();
        $componentType = $recipe->getHelpTextType() ?? ComponentEnum::DIV;
        $inputType = $this->resolveInputType($recipe);
        $callback = $recipe->getHookBag()?->getInputHook() ?? null;

        $attributes = $recipe->getAttributeBag()?->getHelpTextAttributes() ?? null;
        $theme = $recipe->getThemeBag()?->getHelpTextTheme() ?? $this->themeBag?->getHelpTextTheme();

        $attributes = $this->resolveArrayClosure(value: $attributes, input: $input, type: $inputType);
        $themes = $this->resolveArrayClosure(value: $theme, input: $input, type: $inputType);
        $helpText = $this->resolveStringClosure(input: $input, stringClosure: $helpText);

        $themeManager = $this->themeManager;

        $bag = Support::resolveComponentBag($recipe, $this->componentBag);
        $component = Support::resolveComponent(
            component: ($bag instanceof HelpTextComponent) ? $bag->getHelpTextComponent() : null,
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
