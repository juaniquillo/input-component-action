<?php

declare(strict_types=1);

namespace Juaniquillo\InputComponentAction\Utilities;

use Closure;
use Juaniquillo\BackendComponents\Builders\ComponentBuilder;
use Juaniquillo\BackendComponents\Contracts\BackendComponent;
use Juaniquillo\BackendComponents\Contracts\ContentComponent;
use Juaniquillo\BackendComponents\Contracts\ThemeManager;
use Juaniquillo\BackendComponents\Enums\ComponentEnum;
use Juaniquillo\BackendComponents\MainBackendComponent;
use Juaniquillo\BackendComponents\Themes\LocalThemeManager;
use Juaniquillo\CrudAssistant\Contracts\InputInterface;
use Juaniquillo\InputComponentAction\Bags\DefaultComponentBag;
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

    public static function resolveComponentBag(InputComponentRecipe $recipe, ComponentBag|WrapperComponent|LabelComponent|ErrorComponent|HelpTextComponent|null $defaultComponentBag = null): ComponentBag
    {
        return $recipe->getComponentBag() ?? $defaultComponentBag ?? new DefaultComponentBag;
    }

    public static function resolveComponent(
        Closure|string|null $component,
        mixed $type,
        ThemeManager $themeManager,
        Closure|string|null $default = null,
    ): mixed {
        $component = $component ?? $default;

        if ($component instanceof Closure) {
            return $component($type, $themeManager);
        }

        if (is_string($component) && class_exists($component)) {
            return new $component($type, $themeManager);
        }

        return $component ?? new MainBackendComponent($type, $themeManager);
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
