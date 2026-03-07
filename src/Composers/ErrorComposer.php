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
use Juaniquillo\InputComponentAction\Contracts\ErrorTheme;
use Juaniquillo\InputComponentAction\Contracts\ValueManager;
use Juaniquillo\InputComponentAction\Recipes\InputComponentRecipe;

final class ErrorComposer implements ComponentComposer
{
    use IsComposer;

    public function __construct(
        private InputInterface $input,
        private InputComponentRecipe $recipe,
        private ThemeManager $themeManager,
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

        /** @todo Use new component bag to resolve component */
        $component = new MainBackendComponent($componentType, $themeManager);

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
