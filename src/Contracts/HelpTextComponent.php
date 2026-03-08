<?php

declare(strict_types=1);

namespace Juaniquillo\InputComponentAction\Contracts;

use Closure;
use Juaniquillo\BackendComponents\Contracts\BackendComponent;
use Juaniquillo\BackendComponents\Contracts\CompoundComponent;
use Juaniquillo\BackendComponents\Contracts\StaticBuilder;

interface HelpTextComponent
{
    public function setHelpTextComponent(Closure|CompoundComponent|BackendComponent|string $helpTextComponent): static;

    public function getHelpTextComponent(): Closure|CompoundComponent|BackendComponent|string|null;
}
