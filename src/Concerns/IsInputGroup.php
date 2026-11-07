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

    public function inject(
        InputInterface $input,
        InputComponentRecipeInterface $recipe,
        ThemeManager $themeManager,
        string|Closure|null $defaultThemeManager,
        ComponentBag $defaultComponentBag,
        string|Closure $defaultInputGroup,
        ValueManager $values,
        ErrorManager $errors,
        ?ThemeBag $defaultThemeBag = null,
    ): static {
        $this->input = $input;
        $this->recipe = $recipe;
        $this->themeManager = $themeManager;
        $this->defaultThemeManager = $defaultThemeManager;
        $this->defaultInputGroup = $defaultInputGroup;
        $this->values = $values;
        $this->errors = $errors;
        $this->defaultThemeBag = $defaultThemeBag;
        $this->defaultComponentBag = $defaultComponentBag;

        return $this;
    }

    public function setParent(InputInterface $parent): static
    {
        $this->parent = $parent;

        return $this;
    }

    private function getInputComponent(): BackendComponent|ContentComponent|ThemeComponent
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
