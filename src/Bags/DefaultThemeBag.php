<?php

declare(strict_types=1);

namespace Juaniquillo\InputComponentAction\Bags;

use Juaniquillo\InputComponentAction\Concerns\IsThemeBag;
use Juaniquillo\InputComponentAction\Contracts\ThemeBag;

final class DefaultThemeBag implements ThemeBag
{
    use IsThemeBag;
}
