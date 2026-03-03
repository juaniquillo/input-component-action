<?php

declare(strict_types=1);

namespace Juaniquillo\InputComponentAction\Contracts;

use Closure;

interface ThemeBag
{
    public function setInputTheme(Closure|array $inputTheme): static;

    public function getInputTheme(): Closure|array|null;
}
