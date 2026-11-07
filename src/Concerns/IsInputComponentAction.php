<?php

declare(strict_types=1);

namespace Juaniquillo\InputComponentAction\Concerns;

use Closure;
use Exception;
use Juaniquillo\BackendComponents\Contracts\BackendComponent;
use Juaniquillo\BackendComponents\Contracts\ContentComponent;
use Juaniquillo\BackendComponents\Contracts\ThemeComponent;
use Juaniquillo\CrudAssistant\Contracts\InputCollectionInterface;
use Juaniquillo\CrudAssistant\Contracts\InputInterface;
use Juaniquillo\CrudAssistant\Support\InputHelper;
use Juaniquillo\InputComponentAction\Bags\DefaultComponentBag;
use Juaniquillo\InputComponentAction\Bags\DefaultThemeBag;
use Juaniquillo\InputComponentAction\Composers\SlotComposer;
use Juaniquillo\InputComponentAction\Contracts\ComponentBag;
use Juaniquillo\InputComponentAction\Contracts\ErrorManager;
use Juaniquillo\InputComponentAction\Contracts\InputComponentRecipeInterface;
use Juaniquillo\InputComponentAction\Contracts\ThemeBag;
use Juaniquillo\InputComponentAction\Contracts\ValueManager;
use Juaniquillo\InputComponentAction\Enums\Slot;
use Juaniquillo\InputComponentAction\Factories\InputGroupFactory;
use Juaniquillo\InputComponentAction\Groups\DefaultInputGroup;
use Juaniquillo\InputComponentAction\Groups\GroupContext;
use Juaniquillo\InputComponentAction\Managers\DefaultErrorManager;
use Juaniquillo\InputComponentAction\Managers\DefaultValueManager;
use Juaniquillo\InputComponentAction\Resolvers\InputEligibility;
use Juaniquillo\InputComponentAction\Utilities\Support;

trait IsInputComponentAction
{
    private ?InputEligibility $eligibility = null;

    private string|Closure|null $defaultThemeManager = null;

    private string|Closure|null $defaultInputGroup = null;

    private ?ThemeBag $defaultThemeBag = null;

    private ?ComponentBag $defaultComponentBag = null;

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

    public function setDefaultThemeBag(ThemeBag $defaultThemeBag): static
    {
        $this->defaultThemeBag = $defaultThemeBag;

        return $this;
    }

    public function setDefaultComponentBag(ComponentBag $defaultComponentBag): static
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

    public function resolveInputs(InputCollectionInterface|InputInterface $input): BackendComponent&ContentComponent&ThemeComponent
    {
        /**
         * Recursively resolve inputs
         * and input collections.
         */
        if (InputHelper::isCollection($input) && $this->controlsRecursion()) {
            $wrapper = $this->getWrapper($input);

            foreach ($input as $item) {
                if (! $this->eligibility()->isResolvable($item)) {
                    continue;
                }

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

        if (! $component instanceof BackendComponent || ! $component instanceof ContentComponent || ! $component instanceof ThemeComponent) {
            throw new Exception('Modifiers must return a renderable backend component.', 500);
        }

        return $component;
    }

    private function eligibility(): InputEligibility
    {
        return $this->eligibility ??= new InputEligibility(static::getIdentifier());
    }

    public function getInputGroup(InputInterface $input): BackendComponent
    {
        $recipe = Support::getRecipe($input);

        $context = new GroupContext(
            input: $input,
            recipe: $recipe,
            eligibility: $this->eligibility(),
            themeManager: $recipe->getThemeManager() ?? Support::resolveThemeManager($this->defaultThemeManager),
            defaultThemeManager: $this->defaultThemeManager,
            defaultComponentBag: $this->defaultComponentBag ?? new DefaultComponentBag,
            defaultInputGroup: $this->defaultInputGroup ?? DefaultInputGroup::class,
            values: $this->getValueManager($recipe),
            errors: $this->getErrorManager($recipe),
            defaultThemeBag: $this->defaultThemeBag ?? new DefaultThemeBag,
        );

        return InputGroupFactory::init($context);
    }

    public function getWrapper(InputInterface $input): BackendComponent&ContentComponent&ThemeComponent
    {
        $recipe = Support::getRecipe($input);

        $composer = new SlotComposer(
            slot: Slot::WRAPPER,
            input: $input,
            recipe: $recipe,
            themeManager: $recipe->getThemeManager() ?? Support::resolveThemeManager($this->defaultThemeManager),
            componentBag: $this->defaultComponentBag ?? new DefaultComponentBag,
            values: $this->getValueManager($recipe),
            errors: $this->getErrorManager($recipe),
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
