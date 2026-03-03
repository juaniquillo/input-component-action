<?php

declare(strict_types=1);

namespace Juaniquillo\InputComponentAction\Bags;

use Juaniquillo\InputComponentAction\Concerns\HasErrorTheme;
use Juaniquillo\InputComponentAction\Concerns\HasHelpTextTheme;
use Juaniquillo\InputComponentAction\Concerns\HasLabelTheme;
use Juaniquillo\InputComponentAction\Concerns\HasWrapperTheme;
use Juaniquillo\InputComponentAction\Concerns\IsThemeBag;
use Juaniquillo\InputComponentAction\Contracts\ErrorTheme;
use Juaniquillo\InputComponentAction\Contracts\HelpTextTheme;
use Juaniquillo\InputComponentAction\Contracts\LabelTheme;
use Juaniquillo\InputComponentAction\Contracts\ThemeBag;
use Juaniquillo\InputComponentAction\Contracts\WrapperTheme;

final class DefaultThemeBag implements ErrorTheme, HelpTextTheme, LabelTheme, ThemeBag, WrapperTheme
{
    use HasErrorTheme,
        HasHelpTextTheme,
        HasLabelTheme,
        HasWrapperTheme,
        IsThemeBag;
}
