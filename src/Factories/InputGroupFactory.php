<?php

declare(strict_types=1);

namespace Juaniquillo\InputComponentAction\Factories;

use Juaniquillo\BackendComponents\Contracts\BackendComponent;
use Juaniquillo\CrudAssistant\Contracts\InputInterface;
use Juaniquillo\InputComponentAction\Contracts\ErrorManager;
use Juaniquillo\InputComponentAction\Contracts\ErrorTheme;
use Juaniquillo\InputComponentAction\Contracts\HelpTextTheme;
use Juaniquillo\InputComponentAction\Contracts\InputGroup;
use Juaniquillo\InputComponentAction\Contracts\LabelTheme;
use Juaniquillo\InputComponentAction\Contracts\ThemeBag;
use Juaniquillo\InputComponentAction\Contracts\ThemeManager;
use Juaniquillo\InputComponentAction\Contracts\ValueManager;
use Juaniquillo\InputComponentAction\Contracts\WrapperTheme;
use Juaniquillo\InputComponentAction\Groups\DefaultInputGroup;
use Juaniquillo\InputComponentAction\Recipes\InputComponentRecipe;
use Juaniquillo\InputComponentAction\Utilities\Support;

final class InputGroupFactory
{
    public static function initGroup(
        InputInterface $input,
        InputComponentRecipe $recipe,
        ?ValueManager $values,
        ?ErrorManager $errors,
        ?ThemeManager $defaultThemeManager = null,
        ?InputGroup $defaultInputGroup = null,
        ThemeBag|WrapperTheme|LabelTheme|ErrorTheme|HelpTextTheme|null $defaultThemeBag = null,
        ?InputInterface $parent = null): BackendComponent
    {
        $group = $recipe->inputGroup ?? $defaultInputGroup ?? new DefaultInputGroup;

        $group = $group->inject(
            input: $input,
            recipe: $recipe,
            values: $values,
            errors: $errors,
            themeManager: $defaultThemeManager ?? Support::resolveThemeManager($recipe),
            defaultInputGroup: $defaultInputGroup ?? new DefaultInputGroup,
            defaultThemeBag: Support::resolveThemeBag($recipe, $defaultThemeBag),
        );

        if ($parent) {

            $group->setParent($parent);
        }

        return $group->getGroup();

    }
}
