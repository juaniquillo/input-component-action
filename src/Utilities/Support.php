<?php

declare(strict_types=1);

namespace Juaniquillo\InputComponentAction\Utilities;

use Closure;
use Juaniquillo\BackendComponents\Builders\ComponentBuilder;
use Juaniquillo\BackendComponents\Contracts\BackendComponent;
use Juaniquillo\BackendComponents\Contracts\ContentComponent;
use Juaniquillo\BackendComponents\Contracts\ThemeManager;
use Juaniquillo\BackendComponents\Enums\ComponentEnum;
use Juaniquillo\BackendComponents\Themes\LocalThemeManager;
use Juaniquillo\CrudAssistant\Contracts\InputInterface;
use Juaniquillo\CrudAssistant\Contracts\RecipeInterface;
use Juaniquillo\InputComponentAction\Bags\DefaultThemeBag;
use Juaniquillo\InputComponentAction\Contracts\ErrorTheme;
use Juaniquillo\InputComponentAction\Contracts\HelpTextTheme;
use Juaniquillo\InputComponentAction\Contracts\LabelTheme;
use Juaniquillo\InputComponentAction\Contracts\ThemeBag;
use Juaniquillo\InputComponentAction\Contracts\WrapperTheme;
use Juaniquillo\InputComponentAction\InputComponentAction;
use Juaniquillo\InputComponentAction\Recipes\InputComponentRecipe;

final class Support
{
    public static function getRecipe(InputInterface $input): InputComponentRecipe
    {
        return $input->getRecipes()[InputComponentAction::getIdentifier()] ?? new InputComponentRecipe;
    }

    public static function resolveThemeManager(RecipeInterface $recipe, $defaultThemeManager = null): ThemeManager
    {
        return $recipe->defaultThemeManager ?? $defaultThemeManager ?? new LocalThemeManager;
    }

    public static function resolveThemeBag(RecipeInterface $recipe, ThemeBag|WrapperTheme|LabelTheme|ErrorTheme|HelpTextTheme|null $defaultThemeBag = null): ThemeBag
    {
        return $recipe->defaultThemeBag ?? $defaultThemeBag ?? new DefaultThemeBag;
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
