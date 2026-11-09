<?php

declare(strict_types=1);

namespace Juaniquillo\InputComponentAction\Groups;

use Closure;
use Juaniquillo\BackendComponents\Contracts\ThemeManager;
use Juaniquillo\CrudAssistant\Contracts\InputInterface;
use Juaniquillo\InputComponentAction\Contracts\ComponentBag;
use Juaniquillo\InputComponentAction\Contracts\ErrorManager;
use Juaniquillo\InputComponentAction\Contracts\InputComponentRecipeInterface;
use Juaniquillo\InputComponentAction\Contracts\ThemeBag;
use Juaniquillo\InputComponentAction\Contracts\ValueManager;
use Juaniquillo\InputComponentAction\Resolvers\InputEligibility;

final class GroupContext
{
    public function __construct(
        public readonly InputInterface $input,
        public readonly InputComponentRecipeInterface $recipe,
        public readonly InputEligibility $eligibility,
        public readonly ThemeManager $themeManager,
        public readonly string|Closure|null $defaultThemeManager,
        public readonly ComponentBag $defaultComponentBag,
        public readonly string|Closure $defaultInputGroup,
        public readonly ValueManager $values,
        public readonly ErrorManager $errors,
        public readonly ?ThemeBag $defaultThemeBag = null,
        public readonly ?InputInterface $parent = null,
    ) {}
}
