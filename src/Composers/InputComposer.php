<?php

declare(strict_types=1);

namespace Juaniquillo\InputComponentAction\Composers;

use Closure;
use Juaniquillo\BackendComponents\Contracts\BackendComponent;
use Juaniquillo\BackendComponents\Contracts\ContentComponent;
use Juaniquillo\BackendComponents\Contracts\ThemeComponent;
use Juaniquillo\BackendComponents\Contracts\ThemeManager;
use Juaniquillo\CrudAssistant\Contracts\InputCollectionInterface;
use Juaniquillo\CrudAssistant\Contracts\InputInterface;
use Juaniquillo\InputComponentAction\Concerns\IsComposer;
use Juaniquillo\InputComponentAction\Contracts\ComponentBag;
use Juaniquillo\InputComponentAction\Contracts\ErrorManager;
use Juaniquillo\InputComponentAction\Contracts\InputComponentRecipeInterface;
use Juaniquillo\InputComponentAction\Contracts\ThemeBag;
use Juaniquillo\InputComponentAction\Contracts\ValueManager;
use Juaniquillo\InputComponentAction\Enums\Slot;
use Juaniquillo\InputComponentAction\Resolvers\ChildInputResolver;
use Juaniquillo\InputComponentAction\Resolvers\InputEligibility;
use Juaniquillo\InputComponentAction\Utilities\Support;

final class InputComposer
{
    use IsComposer;

    public function __construct(
        private InputInterface $input,
        private InputComponentRecipeInterface $recipe,
        private InputEligibility $eligibility,
        private string|Closure $defaultInputGroup,
        private ThemeManager $themeManager,
        private string|Closure|null $defaultThemeManager,
        private ComponentBag $componentBag,
        private ValueManager $values,
        private ErrorManager $errors,
        private ?ThemeBag $themeBag = null,
    ) {}

    public function build(): BackendComponent&ContentComponent&ThemeComponent
    {
        return $this->buildInputComponent($this->input);
    }

    public function buildInputComponent(InputInterface|InputCollectionInterface $input): BackendComponent&ContentComponent&ThemeComponent
    {

        $recipe = $this->recipe;
        $themeManager = $this->themeManager;
        $valueResolver = $this->values;
        $recipeComponentBag = $recipe->getComponentBag();
        $defaultComponentBag = $this->componentBag;

        $inputType = Support::resolveType($recipe, Slot::INPUT, $defaultComponentBag);

        $currentComponent = $recipeComponentBag?->getInputComponent() ?? $defaultComponentBag->getInputComponent();

        $component = Support::resolveComponent(
            component: $currentComponent,
            type: $inputType,
            themeManager: $themeManager
        );

        /**
         * SubComponents
         */
        $subComponents = $this->buildSubComponentGroup($input);

        /**
         * Access
         */
        $attributes = $recipe->getAttributeBag()?->getInputAttributes() ?? null;
        $theme = $recipe->getThemeBag()?->getInputTheme() ?? $this->themeBag?->getInputTheme();
        $callback = $recipe->getHookBag()?->getInputHook() ?? null;

        $value = $valueResolver->resolve($input, $recipe);

        /**
         * Resolve closures
         */
        $attributes = $this->resolveArrayClosure(value: $attributes, input: $input, type: $inputType);
        $theme = $this->resolveArrayClosure(value: $theme, input: $input, type: $inputType);

        $name = $attributes['name'] ?? $input->getName();
        $id = $attributes['id'] ?? $input->getName();

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

        if ($recipe->labelAsInputContent() && $input->getLabel() !== null) {
            $component->setContent($input->getLabel());
        }

        if ($subComponents) {
            $component->setContents($subComponents);
        }

        if (! $recipe->getDisableBag()?->disableInputValue() && ! \is_array($value)) {
            if ($recipe->valueAsInputContent()) {
                $component->setContent((string) $value);
            } else {
                $component->setAttribute('value', (string) $value);
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

    /**
     * @return array<int, BackendComponent&ContentComponent>|null
     */
    public function buildSubComponentGroup(InputInterface $input): ?array
    {
        $resolver = $this->childResolver();

        if (! $resolver->hasResolvableSubElements($input)) {
            return null;
        }

        return $resolver->resolveChildren($input);
    }

    public function addCheckableAndSelectableAttribute(InputInterface $input, InputComponentRecipeInterface $recipe, BackendComponent&ContentComponent&ThemeComponent $component, ValueManager $valueResolver, mixed $value = null): void
    {
        if ($recipe->isCheckable() || $recipe->isSelectable()) {
            $isSelected = false;

            if ($recipe->useParentValue() && $this->parent) {
                $parentValue = $valueResolver->resolve($this->parent, Support::getRecipe($this->parent));
                $isSelected = $this->valueMatches($value, $parentValue);
            } else {
                $isSelected = (bool) $valueResolver->resolve($input, $recipe, true);
            }

            if ($recipe->isSelectable() && $isSelected) {
                $component->setAttribute('selected', 'selected');
            }

            if ($recipe->isCheckable() && $isSelected) {
                $component->setAttribute('checked', 'checked');
            }
        }
    }

    private function valueMatches(mixed $value, mixed $parentValue): bool
    {
        $values = \is_array($value) ? $value : [$value];
        $parents = \is_array($parentValue) ? $parentValue : [$parentValue];

        foreach ($values as $candidate) {
            foreach ($parents as $parent) {
                if ($candidate == $parent) {
                    return true;
                }
            }
        }

        return false;
    }

    private function childResolver(): ChildInputResolver
    {
        return new ChildInputResolver(
            eligibility: $this->eligibility,
            values: $this->values,
            errors: $this->errors,
            componentBag: $this->componentBag,
            defaultInputGroup: $this->defaultInputGroup,
            defaultThemeManager: $this->defaultThemeManager,
            themeBag: $this->themeBag,
        );
    }
}
