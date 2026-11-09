<?php

declare(strict_types=1);

namespace Juaniquillo\InputComponentAction\Utilities;

use BackedEnum;
use Closure;
use Juaniquillo\BackendComponents\Contracts\BackendComponent;
use Juaniquillo\BackendComponents\Contracts\ContentComponent;
use Juaniquillo\BackendComponents\Contracts\ThemeComponent;
use Juaniquillo\BackendComponents\Contracts\ThemeManager;
use Juaniquillo\BackendComponents\Enums\ComponentEnum;
use Juaniquillo\BackendComponents\MainBackendComponent;
use Juaniquillo\BackendComponents\Themes\LocalThemeManager;
use Juaniquillo\CrudAssistant\Contracts\InputInterface;
use Juaniquillo\InputComponentAction\Contracts\ComponentBag;
use Juaniquillo\InputComponentAction\Contracts\InputComponentRecipeInterface;
use Juaniquillo\InputComponentAction\Contracts\InputGroup;
use Juaniquillo\InputComponentAction\Enums\Slot;
use Juaniquillo\InputComponentAction\Groups\DefaultInputGroup;
use Juaniquillo\InputComponentAction\InputComponentAction;
use Juaniquillo\InputComponentAction\Recipes\InputComponentRecipe;

final class Support
{
    public static function getRecipe(InputInterface $input): InputComponentRecipeInterface
    {
        $recipe = $input->getRecipe(InputComponentAction::getIdentifier());

        if ($recipe instanceof InputComponentRecipeInterface) {
            return $recipe;
        }

        return new InputComponentRecipe;
    }

    public static function resolveType(?InputComponentRecipeInterface $recipe, Slot $slot, ComponentBag $componentBag): string|BackedEnum
    {
        $recipeType = match ($slot) {
            Slot::WRAPPER => $recipe?->getComponentBag()?->getWrapperType(),
            Slot::LABEL => $recipe?->getComponentBag()?->getLabelType(),
            Slot::INPUT => $recipe?->getComponentBag()?->getInputType(),
            Slot::ERROR => $recipe?->getComponentBag()?->getErrorType(),
            Slot::HELP_TEXT => $recipe?->getComponentBag()?->getHelpTextType(),
        };

        if ($recipeType !== null) {
            return $recipeType;
        }

        $defaultType = match ($slot) {
            Slot::WRAPPER => $componentBag->getWrapperType(),
            Slot::LABEL => $componentBag->getLabelType(),
            Slot::INPUT => $componentBag->getInputType(),
            Slot::ERROR => $componentBag->getErrorType(),
            Slot::HELP_TEXT => $componentBag->getHelpTextType(),
        };

        return $defaultType ?? $slot->defaultType();
    }

    public static function resolveThemeManager(string|Closure|null $manager): ThemeManager
    {
        if (is_string($manager) && is_a($manager, ThemeManager::class, true)) {
            return new $manager;
        }

        if ($manager instanceof Closure) {
            $themeManager = $manager();

            if ($themeManager instanceof ThemeManager) {
                return $themeManager;
            }
        }

        return new LocalThemeManager;
    }

    public static function resolveInputGroup(string|Closure|null $group): InputGroup
    {
        if (is_string($group) && is_a($group, InputGroup::class, true)) {
            return new $group;
        }

        if ($group instanceof Closure) {
            $inputGroup = $group();

            if ($inputGroup instanceof InputGroup) {
                return $inputGroup;
            }
        }

        return new DefaultInputGroup;
    }

    public static function resolveComponent(
        Closure|string|null $component,
        string|BackedEnum $type,
        ThemeManager $themeManager,
    ): BackendComponent&ContentComponent&ThemeComponent {
        if (is_string($component) && is_a($component, BackendComponent::class, true)) {
            $instance = new $component($type, $themeManager);

            if ($instance instanceof ContentComponent && $instance instanceof ThemeComponent) {
                return $instance;
            }
        }

        if ($component instanceof Closure) {
            $instance = $component($type, $themeManager);

            if ($instance instanceof BackendComponent && $instance instanceof ContentComponent && $instance instanceof ThemeComponent) {
                return $instance;
            }
        }

        return new MainBackendComponent($type, $themeManager);
    }

    public static function getCollectionWrapper(): BackendComponent&ContentComponent&ThemeComponent
    {
        return new MainBackendComponent(ComponentEnum::COLLECTION);
    }
}
