<?php

declare(strict_types=1);

namespace Juaniquillo\InputComponentAction\Contracts;

use Closure;

interface HelpTextAttributes
{
    public function setHelpTextAttributes(Closure|array $errorAttributes): static;

    public function getHelpTextAttributes(): Closure|array|null;
}
