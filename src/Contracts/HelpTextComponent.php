<?php

declare(strict_types=1);

namespace Juaniquillo\InputComponentAction\Contracts;

use Closure;

interface HelpTextComponent
{
    public function setHelpTextComponent(Closure|string $helpTextComponent): static;

    public function getHelpTextComponent(): Closure|string|null;
}
