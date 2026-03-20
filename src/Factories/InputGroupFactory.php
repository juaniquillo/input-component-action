<?php

declare(strict_types=1);

namespace Juaniquillo\InputComponentAction\Factories;

use Closure;
use Juaniquillo\BackendComponents\Contracts\BackendComponent;
use Juaniquillo\CrudAssistant\Contracts\InputInterface;
use Juaniquillo\InputComponentAction\Bags\DefaultComponentBag;
use Juaniquillo\InputComponentAction\Contracts\ComponentBag;
use Juaniquillo\InputComponentAction\Contracts\ErrorComponent;
use Juaniquillo\InputComponentAction\Contracts\ErrorManager;
use Juaniquillo\InputComponentAction\Contracts\ErrorTheme;
use Juaniquillo\InputComponentAction\Contracts\HelpTextComponent;
use Juaniquillo\InputComponentAction\Contracts\HelpTextTheme;
use Juaniquillo\InputComponentAction\Contracts\InputComponentRecipeInterface;
use Juaniquillo\InputComponentAction\Contracts\InputGroup;
use Juaniquillo\InputComponentAction\Contracts\LabelComponent;
use Juaniquillo\InputComponentAction\Contracts\LabelTheme;
use Juaniquillo\InputComponentAction\Contracts\ThemeBag;
use Juaniquillo\InputComponentAction\Contracts\ValueManager;
use Juaniquillo\InputComponentAction\Contracts\WrapperComponent;
use Juaniquillo\InputComponentAction\Contracts\WrapperTheme;
use Juaniquillo\InputComponentAction\Groups\DefaultInputGroup;
use Juaniquillo\InputComponentAction\Utilities\Support;

final class InputGroupFactory
{
    /**
     * @param  class-string<InputGroup>|Closure|null  $defaultInputGroup
     */
    public static function init(
        InputInterface $input,
        InputComponentRecipeInterface $recipe,
        ?ValueManager $values,
        ?ErrorManager $errors,
        string|Closure|null $defaultThemeManager = null,
        string|Closure|null $defaultInputGroup = null,
        ThemeBag|WrapperTheme|LabelTheme|ErrorTheme|HelpTextTheme|null $defaultThemeBag = null,
        ComponentBag|WrapperComponent|LabelComponent|ErrorComponent|HelpTextComponent|null $defaultComponentBag = null,
        ?InputInterface $parent = null): BackendComponent
    {
        /** @var InputGroup group */
        $group = $recipe->getInputGroup() ?? Support::resolveInputGroup($defaultInputGroup);

        $group = $group->inject(
            input: $input,
            recipe: $recipe,
            values: $values,
            errors: $errors,
            /**
             * Resolve Theme Manager once
             */
            themeManager: $recipe->getThemeManager() ?? Support::resolveThemeManager($defaultThemeManager),

            defaultThemeManager: $defaultThemeManager,

            /**
             * Default needed
             */
            defaultComponentBag: $defaultComponentBag ?? new DefaultComponentBag,
            defaultInputGroup: $defaultInputGroup ?? DefaultInputGroup::class,

            /**
             * No default needed
             */
            defaultThemeBag: $defaultThemeBag,
        );

        if ($parent) {

            $group->setParent($parent);
        }

        return $group->getGroup();

    }
}
