<?php

declare(strict_types=1);

namespace Juaniquillo\InputComponentAction\Concerns;

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
use Juaniquillo\InputComponentAction\Contracts\InputGroup;
use Juaniquillo\InputComponentAction\Contracts\LabelComponent;
use Juaniquillo\InputComponentAction\Contracts\LabelTheme;
use Juaniquillo\InputComponentAction\Contracts\ThemeBag;
use Juaniquillo\InputComponentAction\Contracts\ValueManager;
use Juaniquillo\InputComponentAction\Contracts\WrapperComponent;
use Juaniquillo\InputComponentAction\Contracts\WrapperTheme;
use Juaniquillo\InputComponentAction\Recipes\InputComponentRecipe;

trait IsInputGroup
{
    private InputInterface $input;

    private InputComponentRecipe $recipe;

    private ThemeManager $themeManager;

    private InputGroup $defaultInputGroup;

    private ValueManager $values;

    private ErrorManager $errors;

    private ThemeBag|WrapperTheme|LabelTheme|ErrorTheme|HelpTextTheme|null $defaultThemeBag = null;

    private ComponentBag|WrapperComponent|LabelComponent|ErrorComponent|HelpTextComponent|null $defaultComponentBag = null;

    private ?InputInterface $parent = null;

    public function inject(
        InputInterface $input,
        InputComponentRecipe $recipe,
        ThemeManager $themeManager,
        InputGroup $defaultInputGroup,
        ValueManager $values,
        ErrorManager $errors,
        ThemeBag|WrapperTheme|LabelTheme|ErrorTheme|HelpTextTheme|null $defaultThemeBag = null,
        ComponentBag|WrapperComponent|LabelComponent|ErrorComponent|HelpTextComponent|null $defaultComponentBag = null,
    ): static {
        $this->input = $input;
        $this->recipe = $recipe;
        $this->themeManager = $themeManager;
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
            defaultInputGroup: $this->defaultInputGroup,
            values: $this->values,
            errors: $this->errors,
            themeBag: $this->defaultThemeBag,
            componentBag: $this->defaultComponentBag,
        );

        if ($this->parent) {
            $composer->setParent($this->parent);
        }

        return $composer->build();
    }
}
