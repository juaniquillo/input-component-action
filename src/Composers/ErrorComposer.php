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
use Juaniquillo\InputComponentAction\Contracts\ErrorComponent;
use Juaniquillo\InputComponentAction\Contracts\ErrorManager;
use Juaniquillo\InputComponentAction\Contracts\ErrorTheme;
use Juaniquillo\InputComponentAction\Contracts\HelpTextComponent;
use Juaniquillo\InputComponentAction\Contracts\LabelComponent;
use Juaniquillo\InputComponentAction\Contracts\ValueManager;
use Juaniquillo\InputComponentAction\Contracts\WrapperComponent;
use Juaniquillo\InputComponentAction\Recipes\InputComponentRecipe;
use Juaniquillo\InputComponentAction\Utilities\Support;

final class ErrorComposer implements ComponentComposer
{
    use IsComposer;

    public function __construct(
        private InputInterface $input,
        private InputComponentRecipe $recipe,
        private ThemeManager $themeManager,
        private ComponentBag|WrapperComponent|LabelComponent|ErrorComponent|HelpTextComponent $componentBag,
        private ?ValueManager $values = null,
        private ?ErrorManager $errors = null,
        private ?ErrorTheme $themeBag = null,
    ) {}

    public function build(): BackendComponent|ContentComponent|ThemeComponent
    {
        $input = $this->input;
        $recipe = $this->recipe;
        $errorResolver = $this->errors;
        $callback = $recipe->getHookBag() ?? new DefaultHookBag;

        $componentType = $this->resolveErrorType($recipe);
        $themeManager = $this->themeManager;

        $bag = Support::resolveComponentBag($recipe, $this->componentBag);
        $component = Support::resolveComponent(
            component: ($bag instanceof ErrorComponent) ? $bag->getErrorComponent() : null,
            type: $componentType,
            themeManager: $themeManager
        );

        $inputType = $this->resolveInputType($recipe);

        $theme = $recipe->getThemeBag()?->getErrorTheme() ?? $this->themeBag?->getErrorTheme();
        $themes = $this->resolveArrayClosure(value: $theme, input: $input, type: $componentType);

        $error = $errorResolver->resolve($input, $recipe);
        if ($error) {
            $component->setContent($error);
        }

        if ($themes) {
            $component->setThemes($themes);
        }

        $component = $this->resolveComponentHook(
            component: $component,
            closure: $callback->getErrorHook(),
            input: $input,
            type: $inputType,
            values: $this->values,
            errors: $this->errors,
        );

        return $component;
    }
}
