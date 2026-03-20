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
use Juaniquillo\InputComponentAction\Contracts\ErrorComponent;
use Juaniquillo\InputComponentAction\Contracts\ErrorManager;
use Juaniquillo\InputComponentAction\Contracts\ErrorTheme;
use Juaniquillo\InputComponentAction\Contracts\HelpTextComponent;
use Juaniquillo\InputComponentAction\Contracts\HelpTextTheme;
use Juaniquillo\InputComponentAction\Contracts\InputComponentRecipeInterface;
use Juaniquillo\InputComponentAction\Contracts\LabelComponent;
use Juaniquillo\InputComponentAction\Contracts\LabelTheme;
use Juaniquillo\InputComponentAction\Contracts\ThemeBag;
use Juaniquillo\InputComponentAction\Contracts\ValueManager;
use Juaniquillo\InputComponentAction\Contracts\WrapperComponent;
use Juaniquillo\InputComponentAction\Contracts\WrapperTheme;

trait IsInputGroup
{
    private InputInterface $input;

    private InputComponentRecipeInterface $recipe;

    private ThemeManager $themeManager;

    private string|Closure|null $defaultThemeManager;

    private string|Closure $defaultInputGroup;

    private ValueManager $values;

    private ErrorManager $errors;

    private ThemeBag|WrapperTheme|LabelTheme|ErrorTheme|HelpTextTheme|null $defaultThemeBag = null;

    private ComponentBag|WrapperComponent|LabelComponent|ErrorComponent|HelpTextComponent|null $defaultComponentBag = null;

    private ?InputInterface $parent = null;

    public function inject(
        InputInterface $input,
        InputComponentRecipeInterface $recipe,
        ThemeManager $themeManager,
        string|Closure|null $defaultThemeManager,
        ComponentBag|WrapperComponent|LabelComponent|ErrorComponent|HelpTextComponent $defaultComponentBag,
        string|Closure $defaultInputGroup,
        ValueManager $values,
        ErrorManager $errors,
        ThemeBag|WrapperTheme|LabelTheme|ErrorTheme|HelpTextTheme|null $defaultThemeBag = null,
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
