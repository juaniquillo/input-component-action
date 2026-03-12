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
use Juaniquillo\InputComponentAction\Bags\DefaultThemeBag;
use Juaniquillo\InputComponentAction\Contracts\ComponentBag;
use Juaniquillo\InputComponentAction\Contracts\ErrorComponent;
use Juaniquillo\InputComponentAction\Contracts\ErrorTheme;
use Juaniquillo\InputComponentAction\Contracts\HelpTextComponent;
use Juaniquillo\InputComponentAction\Contracts\HelpTextTheme;
use Juaniquillo\InputComponentAction\Contracts\LabelComponent;
use Juaniquillo\InputComponentAction\Contracts\LabelTheme;
use Juaniquillo\InputComponentAction\Contracts\ThemeBag;
use Juaniquillo\InputComponentAction\Contracts\WrapperComponent;
use Juaniquillo\InputComponentAction\Contracts\WrapperTheme;
use Juaniquillo\InputComponentAction\Defaults\InputTypes;
use Juaniquillo\InputComponentAction\InputComponentAction;
use Juaniquillo\InputComponentAction\Recipes\InputComponentRecipe;

final class Support
{
    public static function getRecipe(InputInterface $input): InputComponentRecipe
    {
        return $input->getRecipes()[InputComponentAction::getIdentifier()] ?? new InputComponentRecipe;
    }

    public static function resolveThemeManager(InputComponentRecipe $recipe, $defaultThemeManager = null): ThemeManager
    {
        return $recipe->getThemeManager() ?? $defaultThemeManager ?? new LocalThemeManager;
    }

    public static function resolveThemeBag(InputComponentRecipe $recipe, ThemeBag|WrapperTheme|LabelTheme|ErrorTheme|HelpTextTheme|null $defaultThemeBag = null): ThemeBag
    {
        return $recipe->getThemeBag() ?? $defaultThemeBag ?? new DefaultThemeBag;
    }

    public static function resolveWrapperType(?InputComponentRecipe $recipe, WrapperComponent $componentBag): string|ComponentEnum
    {
        return $recipe->getComponentBag()?->getWrapperType() ?? $componentBag->getWrapperType() ?? InputTypes::WRAPPER;
    }

    public static function resolveLabelType(?InputComponentRecipe $recipe, LabelComponent $componentBag): string|ComponentEnum
    {
        return $recipe->getComponentBag()?->getLabelType() ?? $componentBag->getLabelType() ?? InputTypes::LABEL;
    }

    public static function resolveInputType(?InputComponentRecipe $recipe, ComponentBag $componentBag): string|ComponentEnum
    {
        return $recipe->getComponentBag()?->getInputType() ?? $componentBag->getInputType() ?? InputTypes::INPUT;
    }

    public static function resolveErrorType(?InputComponentRecipe $recipe, ErrorComponent $componentBag): string|ComponentEnum
    {
        return $recipe->getComponentBag()?->getErrorType() ?? $componentBag->getErrorType() ?? InputTypes::HELP_TEXT;
    }

    public static function resolveHelpTextType(?InputComponentRecipe $recipe, HelpTextComponent $componentBag): string|ComponentEnum
    {
        return $recipe->getComponentBag()?->getErrorType() ?? $componentBag->getHelpTextType() ?? InputTypes::HELP_TEXT;
    }

    /**
     * @param  class-string<BackendComponent|ContentComponent|ThemeComponent|CompoundComponent>|Closure(string|BackedEnum $type, ThemeManager $manager): (BackendComponent|ContentComponent|ThemeComponent|CompoundComponent)  $component
     */
    public static function resolveComponent(
        Closure|string|null $component,
        mixed $type,
        ThemeManager $themeManager,
    ): BackendComponent|ContentComponent|ThemeComponent|CompoundComponent {

        if ($component instanceof Closure) {
            return $component($type, $themeManager);
        }

        if (is_string($component) && class_exists($component)) {
            return new $component($type, $themeManager);
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
