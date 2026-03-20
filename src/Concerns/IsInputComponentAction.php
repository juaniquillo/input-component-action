<?php

declare(strict_types=1);

namespace Juaniquillo\InputComponentAction\Concerns;

use Closure;
use Juaniquillo\BackendComponents\Contracts\BackendComponent;
use Juaniquillo\BackendComponents\Contracts\ContentComponent;
use Juaniquillo\BackendComponents\Contracts\ThemeComponent;
use Juaniquillo\CrudAssistant\Contracts\InputInterface;
use Juaniquillo\CrudAssistant\CrudAssistant;
use Juaniquillo\CrudAssistant\InputCollection;
use Juaniquillo\InputComponentAction\Bags\DefaultComponentBag;
use Juaniquillo\InputComponentAction\Bags\DefaultThemeBag;
use Juaniquillo\InputComponentAction\Composers\WrapperComposer;
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
use Juaniquillo\InputComponentAction\Factories\InputGroupFactory;
use Juaniquillo\InputComponentAction\Managers\DefaultErrorManager;
use Juaniquillo\InputComponentAction\Managers\DefaultValueManager;
use Juaniquillo\InputComponentAction\Utilities\Support;

trait IsInputComponentAction
{
    private string|Closure|null $defaultThemeManager = null;

    private string|Closure|null $defaultInputGroup = null;

    private ThemeBag|WrapperTheme|LabelTheme|ErrorTheme|HelpTextTheme|null $defaultThemeBag = null;

    private ComponentBag|WrapperComponent|LabelComponent|ErrorComponent|HelpTextComponent|null $defaultComponentBag = null;

    private ?object $model = null;

    private ?ValueManager $valueBag = null;

    private ?ErrorManager $errorBag = null;

    public function setThemeManager(string|Closure|null $defaultThemeManager): static
    {
        $this->defaultThemeManager = $defaultThemeManager;

        return $this;
    }

    public function setDefaultInputGroup(string|Closure|null $defaultInputGroup): static
    {
        $this->defaultInputGroup = $defaultInputGroup;

        return $this;
    }

    public function setDefaultThemeBag(ThemeBag|WrapperTheme|LabelTheme|ErrorTheme|HelpTextTheme $defaultThemeBag): static
    {
        $this->defaultThemeBag = $defaultThemeBag;

        return $this;
    }

    public function setDefaultComponentBag(ComponentBag|WrapperComponent|LabelComponent|ErrorComponent|HelpTextComponent $defaultComponentBag): static
    {
        $this->defaultComponentBag = $defaultComponentBag;

        return $this;
    }

    public function setModel(?object $model = null): static
    {
        $this->model = $model;

        return $this;
    }

    public function setValueManager(ValueManager $valueBag): static
    {
        $this->valueBag = $valueBag;

        return $this;
    }

    public function setErrorManager(ErrorManager $errorBag): static
    {
        $this->errorBag = $errorBag;

        return $this;
    }

    public function resolveInputs(InputCollection|InputInterface|\IteratorAggregate $input): array|BackendComponent|ContentComponent
    {
        /**
         * Recursively resolve inputs
         * and input collections.
         */
        if (CrudAssistant::isInputCollection($input) && $this->controlsRecursion()) {
            $wrapper = $this->getWrapper($input);

            foreach ($input as $item) {
                $wrapper->setContent($this->resolveInputs($item));
            }

            return $wrapper;
        }

        $inputGroup = $this->getInputGroup($input);

        /** Modifiers on the whole input group component */
        $component = $this->modifiers(
            value: $inputGroup,
            input: $input,
        );

        return $component;

    }

    public function getInputGroup(InputInterface $input): BackendComponent
    {
        $recipe = Support::getRecipe($input);

        return InputGroupFactory::init(
            input: $input,
            recipe: $recipe,
            defaultThemeBag: $this->defaultThemeBag ?? new DefaultThemeBag,
            values: $this->getValueManager($recipe),
            errors: $this->getErrorManager($recipe),
            defaultComponentBag: $this->defaultComponentBag,
            defaultThemeManager: $this->defaultThemeManager,
            defaultInputGroup: $this->defaultInputGroup,
        );

    }

    public function getWrapper(InputInterface $input): BackendComponent|ContentComponent|ThemeComponent
    {
        $recipe = Support::getRecipe($input);

        $composer = new WrapperComposer(
            input: $input,
            themeManager: $recipe->getThemeManager() ?? Support::resolveThemeManager($this->defaultThemeManager),
            componentBag: $this->defaultComponentBag ?? new DefaultComponentBag,
            themeBag: $this->defaultThemeBag,
        );

        return $composer->build();
    }

    public function getValueManager(?InputComponentRecipeInterface $recipe): ValueManager
    {
        $bag = $recipe?->getValueBag() ?? $this->valueBag ?? new DefaultValueManager;

        return $bag->setValues($this->values)
            ->setModel($this->model);
    }

    public function getErrorManager(?InputComponentRecipeInterface $recipe): ErrorManager
    {
        $bag = $recipe?->getErrorBag() ?? $this->errorBag ?? new DefaultErrorManager;

        return $bag->setErrors($this->errors);
    }
}
