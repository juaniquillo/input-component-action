<?php

declare(strict_types=1);

namespace Juaniquillo\InputComponentAction\Composers;

use Juaniquillo\BackendComponents\Contracts\BackendComponent;
use Juaniquillo\BackendComponents\Contracts\ContentComponent;
use Juaniquillo\BackendComponents\Contracts\ThemeComponent;
use Juaniquillo\BackendComponents\Contracts\ThemeManager;
use Juaniquillo\CrudAssistant\Contracts\InputCollectionInterface;
use Juaniquillo\CrudAssistant\Contracts\InputInterface;
use Juaniquillo\InputComponentAction\Concerns\IsComposer;
use Juaniquillo\InputComponentAction\Contracts\ComponentBag;
use Juaniquillo\InputComponentAction\Contracts\ComponentComposer;
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
use Juaniquillo\InputComponentAction\Factories\InputGroupFactory;
use Juaniquillo\InputComponentAction\Recipes\InputComponentRecipe;
use Juaniquillo\InputComponentAction\Utilities\Support;

final class InputComposer implements ComponentComposer
{
    use IsComposer;

    public function __construct(
        private InputInterface $input,
        private InputComponentRecipe $recipe,
        private InputGroup $defaultInputGroup,
        private ThemeManager $themeManager,
        private ComponentBag|WrapperComponent|LabelComponent|ErrorComponent|HelpTextComponent $componentBag,
        private ?ValueManager $values,
        private ?ErrorManager $errors,
        private ThemeBag|WrapperTheme|LabelTheme|ErrorTheme|HelpTextTheme|null $themeBag = null,
    ) {}

    public function build(): BackendComponent|ContentComponent|ThemeComponent
    {
        return $this->buildInputComponent($this->input);
    }

    public function buildInputComponent(InputInterface|InputCollectionInterface $input): BackendComponent|ContentComponent
    {

        $recipe = $this->recipe;
        $inputType = $this->resolveInputType($recipe);
        $themeManager = $this->themeManager;
        $valueResolver = $this->values;
        $recipeComponentBag = $recipe->getComponentBag();
        $defaultComponentBag = $this->componentBag;

        $currentComponent = $recipeComponentBag?->getInputComponent() ?? $defaultComponentBag->getInputComponent();

        $component = Support::resolveComponent(
            component: $currentComponent,
            type: $inputType,
            themeManager: $themeManager
        );

        /**
         * SubComponents
         */
        $subComponents = $this->buildSubComponentGroup($recipe);

        /**
         * Access
         */
        $attributes = $recipe->getAttributeBag()?->getInputAttributes() ?? null;
        $theme = $recipe->getThemeBag()?->getInputTheme() ?? $this->themeBag?->getInputTheme();
        $callback = $recipe->getHookBag()?->getInputHook() ?? null;

        $value = (string) $valueResolver->resolve($input, $recipe);
        $name = $this->resolveInputName($input, $recipe);
        $id = $this->resolveInputId($input, $recipe);

        /**
         * Resolve closures
         */
        $attributes = $this->resolveArrayClosure(value: $attributes, input: $input, type: $inputType);
        $theme = $this->resolveArrayClosure(value: $theme, input: $input, type: $inputType);

        /**
         * Default attributes
         */
        if (! $recipe->getDisableBag()?->disableDefaultNameAttribute()) {
            $component->setAttribute('name', $name);
        }

        if (! $recipe->getDisableBag()?->disableDefaultIdAttribute()) {
            $component->setAttribute('id', $id);
        }

        if ($theme) {
            $component->setThemes($theme);
        }

        if ($recipe->labelAsInputContent()) {
            $component->setContent($input->getLabel());
        }

        if ($subComponents) {
            $component->setContents($subComponents);
        }

        if (! $recipe->getDisableBag()?->disableInputValue()) {
            if ($recipe->valueAsInputContent()) {
                $component->setContent($value);
            } else {
                $component->setAttribute('value', $value);
            }
        }

        /**
         * Checkable and selectable inputs
         */
        $this->addCheckableAndSelectableAttribute($input, $recipe, $component, $valueResolver, $value);

        /**
         * Set/overwrite attributes
         */
        if ($attributes) {
            $component->setAttributes($attributes);
        }

        $component = $this->resolveComponentHook(
            component: $component,
            closure: $callback,
            input: $input,
            type: $inputType,
            values: $this->values,
            errors: $this->errors,
        );

        return $component;
    }

    public function buildSubComponentGroup(InputComponentRecipe $recipe): ?array
    {
        $input = $this->input;

        $subElements = $input->getSubElements();
        $components = [];

        if (! $subElements) {
            return null;
        }

        foreach ($subElements->getInputs() as $element) {
            $elementRecipe = Support::getRecipe($element);
            $components[] = $this->resolveGroup(
                input: $element,
                recipe: $elementRecipe,
                defaultInputGroup: $this->defaultInputGroup,
                parent: $input,
            );
        }

        return $components;
    }

    public function addCheckableAndSelectableAttribute(InputInterface $input, InputComponentRecipe $recipe, BackendComponent $component, ValueManager $valueResolver, ?string $value = null): void
    {
        if ($recipe->isCheckable() || $recipe->isSelectable()) {

            $isSelected = false;

            if ($recipe->useParentValue() && $this->parent) {
                $parentValue = $valueResolver->resolve($this->parent, Support::getRecipe($this->parent));
                $isSelected = $value == $parentValue;
            } else {
                $isSelected = $valueResolver->resolve($input, $recipe, true);
            }

            if ($recipe->isSelectable() && $isSelected) {
                $component->setAttribute('selected', 'selected');
            }

            if ($recipe->isCheckable() && $isSelected) {
                $component->setAttribute('checked', 'checked');
            }
        }
    }

    private function resolveGroup(
        InputInterface $input,
        InputComponentRecipe $recipe,
        InputGroup $defaultInputGroup,
        ?InputInterface $parent = null,
    ): BackendComponent {
        return InputGroupFactory::init(
            input: $input,
            recipe: $recipe,
            values: $this->values,
            errors: $this->errors,
            defaultThemeBag: $this->themeBag,
            defaultThemeManager: $this->themeManager,
            defaultInputGroup: $defaultInputGroup,
            parent: $parent,
        );

    }
}
