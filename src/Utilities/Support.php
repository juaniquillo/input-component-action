<?php

declare(strict_types=1);

namespace Juaniquillo\InputComponentAction\Utilities;

use BackedEnum;
use Closure;
use Juaniquillo\BackendComponents\Builders\ComponentBuilder;
use Juaniquillo\BackendComponents\Contracts\BackendComponent;
use Juaniquillo\BackendComponents\Contracts\CompoundComponent;
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

    public static function resolveWrapperType(?InputComponentRecipeInterface $recipe, ComponentBag $componentBag): string|BackedEnum
    {
        return self::resolveType($recipe, Slot::WRAPPER, $componentBag);
    }

    public static function resolveLabelType(?InputComponentRecipeInterface $recipe, ComponentBag $componentBag): string|BackedEnum
    {
        return self::resolveType($recipe, Slot::LABEL, $componentBag);
    }

    public static function resolveInputType(?InputComponentRecipeInterface $recipe, ComponentBag $componentBag): string|BackedEnum
    {
        return self::resolveType($recipe, Slot::INPUT, $componentBag);
    }

    public static function resolveErrorType(?InputComponentRecipeInterface $recipe, ComponentBag $componentBag): string|BackedEnum
    {
        return self::resolveType($recipe, Slot::ERROR, $componentBag);
    }

    public static function resolveHelpTextType(?InputComponentRecipeInterface $recipe, ComponentBag $componentBag): string|BackedEnum
    {
        return self::resolveType($recipe, Slot::HELP_TEXT, $componentBag);
    }

    public static function resolveThemeManager(string|Closure|null $manager): ThemeManager
    {
        if (is_string($manager) && class_exists($manager)) {
            return new $manager;
        }

        if ($manager instanceof Closure) {
            return $manager();
        }

        return new LocalThemeManager;
    }

    /**
     * @param  class-string<InputGroup>|Closure  $group
     */
    public static function resolveInputGroup(string|Closure|null $group): InputGroup
    {

        if (is_string($group) && class_exists($group)) {
            return new $group;
        }

        if ($group instanceof Closure) {
            return $group();
        }

        return new DefaultInputGroup;
    }

    /**
     * @param  class-string<BackendComponent|ContentComponent|ThemeComponent|CompoundComponent>|Closure(string|BackedEnum $type, ThemeManager $manager): (BackendComponent|ContentComponent|ThemeComponent|CompoundComponent)  $component
     */
    public static function resolveComponent(
        Closure|string|null $component,
        mixed $type,
        ThemeManager $themeManager,
    ): BackendComponent|ContentComponent|ThemeComponent|CompoundComponent {

        if (is_string($component) && class_exists($component)) {
            return new $component($type, $themeManager);
        }

        if ($component instanceof Closure) {
            return $component($type, $themeManager);
        }

        return new MainBackendComponent($type, $themeManager);
    }

    public static function isClosure(mixed $value): bool
    {
        return $value instanceof Closure;
    }

    public static function getCollectionWrapper(): BackendComponent|ContentComponent
    {
        return ComponentBuilder::make(ComponentEnum::COLLECTION);
    }
}
