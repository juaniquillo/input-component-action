<?php

declare(strict_types=1);

namespace Juaniquillo\InputComponentAction\Contracts;

use Closure;
use Juaniquillo\BackendComponents\Contracts\BackendComponent;
use Juaniquillo\BackendComponents\Contracts\ContentComponent;
use Juaniquillo\BackendComponents\Contracts\ThemeManager;
use Juaniquillo\CrudAssistant\Contracts\InputInterface;

interface InputGroup
{
    public function inject(
        InputInterface $input,
        InputComponentRecipeInterface $recipe,
        ThemeManager $themeManager,
        string|Closure|null $defaultThemeManager,
        ComponentBag|WrapperComponent|LabelComponent|ErrorComponent|HelpTextComponent $defaultComponentBag,
        string|Closure $defaultInputGroup,
        ValueManager $values,
        ErrorManager $errors,
        ThemeBag|WrapperTheme|LabelTheme|ErrorTheme|HelpTextTheme|null $defaultThemeBag = null,
    ): static;

    public function getGroup(): BackendComponent|ContentComponent;

    public function setParent(InputInterface $parent): static;
}
