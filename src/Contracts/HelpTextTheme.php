<?php

declare(strict_types=1);

namespace Juaniquillo\InputComponentAction\Contracts;

use Closure;

interface HelpTextTheme
{
    public function setHelpTextTheme(Closure|array $helpTextTheme): static;

    public function getHelpTextTheme(): Closure|array|null;
}
