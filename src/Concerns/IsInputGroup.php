<?php

declare(strict_types=1);

namespace Juaniquillo\InputComponentAction\Concerns;

use Closure;
use Juaniquillo\BackendComponents\Contracts\BackendComponent;
use Juaniquillo\BackendComponents\Contracts\ContentComponent;
use Juaniquillo\BackendComponents\Contracts\ThemeComponent;
use Juaniquillo\BackendComponents\Contracts\ThemeManager;
use Juaniquillo\CrudAssistant\Contracts\InputInterface;
use Juaniquillo\InputComponentAction\Composers\InputComposer;
use Juaniquillo\InputComponentAction\Contracts\ComponentBag;
use Juaniquillo\InputComponentAction\Contracts\ErrorManager;
use Juaniquillo\InputComponentAction\Contracts\InputComponentRecipeInterface;
use Juaniquillo\InputComponentAction\Contracts\ThemeBag;
use Juaniquillo\InputComponentAction\Contracts\ValueManager;
use Juaniquillo\InputComponentAction\Groups\GroupContext;

trait IsInputGroup
{
    private InputInterface $input;

    private InputComponentRecipeInterface $recipe;

    private ThemeManager $themeManager;

    private string|Closure|null $defaultThemeManager;

    private string|Closure $defaultInputGroup;

    private ValueManager $values;

    private ErrorManager $errors;

    private ?ThemeBag $defaultThemeBag = null;

    private ComponentBag $defaultComponentBag;

    private ?InputInterface $parent = null;

    public function inject(GroupContext $context): static
    {
        $this->input = $context->input;
        $this->recipe = $context->recipe;
        $this->themeManager = $context->themeManager;
        $this->defaultThemeManager = $context->defaultThemeManager;
        $this->defaultInputGroup = $context->defaultInputGroup;
        $this->values = $context->values;
        $this->errors = $context->errors;
        $this->defaultThemeBag = $context->defaultThemeBag;
        $this->defaultComponentBag = $context->defaultComponentBag;
        $this->parent = $context->parent;

        return $this;
    }

    private function getInputComponent(): BackendComponent&ContentComponent&ThemeComponent
    {
        $composer = new InputComposer(
            input: $this->input,
            recipe: $this->recipe,
            themeManager: $this->themeManager,
            defaultThemeManager: $this->defaultThemeManager,
            componentBag: $this->defaultComponentBag,
            defaultInputGroup: $this->defaultInputGroup,
            values: $this->values,
            errors: $this->errors,
            themeBag: $this->defaultThemeBag,
        );

        if ($this->parent) {
            $composer->setParent($this->parent);
        }

        return $composer->build();
    }
}
