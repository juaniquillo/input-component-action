<?php

declare(strict_types=1);

namespace Juaniquillo\InputComponentAction\Composers;

use Closure;
use InvalidArgumentException;
use Juaniquillo\BackendComponents\Contracts\BackendComponent;
use Juaniquillo\BackendComponents\Contracts\ContentComponent;
use Juaniquillo\BackendComponents\Contracts\ThemeComponent;
use Juaniquillo\BackendComponents\Contracts\ThemeManager;
use Juaniquillo\CrudAssistant\Contracts\InputInterface;
use Juaniquillo\InputComponentAction\Concerns\IsComposer;
use Juaniquillo\InputComponentAction\Contracts\ComponentBag;
use Juaniquillo\InputComponentAction\Contracts\ErrorManager;
use Juaniquillo\InputComponentAction\Contracts\InputComponentRecipeInterface;
use Juaniquillo\InputComponentAction\Contracts\ThemeBag;
use Juaniquillo\InputComponentAction\Contracts\ValueManager;
use Juaniquillo\InputComponentAction\Enums\Slot;
use Juaniquillo\InputComponentAction\Utilities\Support;

final class SlotComposer
{
    use IsComposer;

    public function __construct(
        private Slot $slot,
        private InputInterface $input,
        private InputComponentRecipeInterface $recipe,
        private ThemeManager $themeManager,
        private ComponentBag $componentBag,
        private ?ValueManager $values = null,
        private ?ErrorManager $errors = null,
        private ?ThemeBag $themeBag = null,
        private ?string $resolvedError = null,
    ) {
        if ($slot === Slot::INPUT) {
            throw new InvalidArgumentException('The input slot is handled by the InputComposer.');
        }
    }

    public function build(): BackendComponent&ContentComponent&ThemeComponent
    {
        $input = $this->input;
        $recipe = $this->recipe;
        $inputType = Support::resolveType($recipe, Slot::INPUT, $this->componentBag);
        $componentType = Support::resolveType($recipe, $this->slot, $this->componentBag);

        $component = Support::resolveComponent(
            component: $this->resolveComponent(),
            type: $componentType,
            themeManager: $this->themeManager,
        );

        $attributes = $this->resolveArrayClosure($this->resolveAttributes(), $input, $inputType);
        $theme = $this->resolveArrayClosure($this->resolveTheme(), $input, $inputType);

        $this->applyContent($component);

        if ($attributes) {
            $component->setAttributes($attributes);
        }

        if ($theme) {
            $component->setThemes($theme);
        }

        return $this->resolveComponentHook(
            component: $component,
            closure: $this->resolveHook(),
            input: $input,
            type: $inputType,
            values: $this->values,
            errors: $this->errors,
        );
    }

    private function resolveComponent(): Closure|string|null
    {
        $recipeBag = $this->recipe->getComponentBag();

        return match ($this->slot) {
            Slot::WRAPPER => $recipeBag?->getWrapperComponent() ?? $this->componentBag->getWrapperComponent(),
            Slot::LABEL => $recipeBag?->getLabelComponent() ?? $this->componentBag->getLabelComponent(),
            Slot::ERROR => $recipeBag?->getErrorComponent() ?? $this->componentBag->getErrorComponent(),
            Slot::HELP_TEXT => $recipeBag?->getHelpTextComponent() ?? $this->componentBag->getHelpTextComponent(),
            Slot::INPUT => throw new InvalidArgumentException('The input slot is handled by the InputComposer.'),
        };
    }

    /**
     * @return array<string, int|string|null>|Closure|null
     */
    private function resolveAttributes(): Closure|array|null
    {
        $bag = $this->recipe->getAttributeBag();

        return match ($this->slot) {
            Slot::WRAPPER => $bag?->getWrapperAttributes(),
            Slot::LABEL => $bag?->getLabelAttributes(),
            Slot::ERROR => $bag?->getErrorAttributes(),
            Slot::HELP_TEXT => $bag?->getHelpTextAttributes(),
            Slot::INPUT => null,
        };
    }

    /**
     * @return array<string, string|array<int|string, string>>|Closure|null
     */
    private function resolveTheme(): Closure|array|null
    {
        $recipeTheme = match ($this->slot) {
            Slot::WRAPPER => $this->recipe->getThemeBag()?->getWrapperTheme(),
            Slot::LABEL => $this->recipe->getThemeBag()?->getLabelTheme(),
            Slot::ERROR => $this->recipe->getThemeBag()?->getErrorTheme(),
            Slot::HELP_TEXT => $this->recipe->getThemeBag()?->getHelpTextTheme(),
            Slot::INPUT => null,
        };

        if ($recipeTheme !== null) {
            return $recipeTheme;
        }

        return match ($this->slot) {
            Slot::WRAPPER => $this->themeBag?->getWrapperTheme(),
            Slot::LABEL => $this->themeBag?->getLabelTheme(),
            Slot::ERROR => $this->themeBag?->getErrorTheme(),
            Slot::HELP_TEXT => $this->themeBag?->getHelpTextTheme(),
            Slot::INPUT => null,
        };
    }

    private function resolveHook(): ?Closure
    {
        $bag = $this->recipe->getHookBag();

        return match ($this->slot) {
            Slot::WRAPPER => $bag?->getWrapperHook(),
            Slot::LABEL => $bag?->getLabelHook(),
            Slot::ERROR => $bag?->getErrorHook(),
            Slot::HELP_TEXT => $bag?->getHelpTextHook(),
            Slot::INPUT => null,
        };
    }

    private function applyContent(BackendComponent&ContentComponent&ThemeComponent $component): void
    {
        switch ($this->slot) {
            case Slot::WRAPPER:
                $this->applyWrapperContent($component);
                break;
            case Slot::LABEL:
                $this->applyLabelContent($component);
                break;
            case Slot::ERROR:
                $this->applyErrorContent($component);
                break;
            case Slot::HELP_TEXT:
                $this->applyHelpTextContent($component);
                break;
            case Slot::INPUT:
                break;
        }
    }

    private function applyWrapperContent(BackendComponent&ContentComponent&ThemeComponent $component): void
    {
        if ($this->recipe->labelAsInputContent() && $this->input->getLabel() !== null) {
            $component->setContent($this->input->getLabel());
        }
    }

    private function applyLabelContent(BackendComponent&ContentComponent&ThemeComponent $component): void
    {
        $label = $this->resolveStringClosure(
            $this->input,
            $this->recipe->getLabel() ?? $this->input->getLabel(),
        );

        if (! $this->recipe->isEmptyLabel() && $label !== null) {
            $component->setContent($label);
        }

        if (! $this->recipe->getDisableBag()?->disableDefaultForAttribute()) {
            $component->setAttribute('for', $this->input->getName());
        }
    }

    private function applyErrorContent(BackendComponent&ContentComponent&ThemeComponent $component): void
    {
        $error = $this->resolvedError ?? $this->errors?->resolve($this->input, $this->recipe);

        if ($error !== null && $error !== '') {
            $component->setContent($error);
        }
    }

    private function applyHelpTextContent(BackendComponent&ContentComponent&ThemeComponent $component): void
    {
        $helpText = $this->resolveStringClosure($this->input, $this->recipe->getHelpText());

        if ($helpText !== null && $helpText !== '') {
            $component->setContent($helpText);
        }
    }
}
