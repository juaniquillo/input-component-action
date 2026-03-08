<?php

declare(strict_types=1);

namespace Juaniquillo\InputComponentAction\Contracts;

use Closure;
use Juaniquillo\BackendComponents\Contracts\BackendComponent;
use Juaniquillo\BackendComponents\Contracts\CompoundComponent;
use Juaniquillo\BackendComponents\Contracts\StaticBuilder;

interface WrapperComponent
{
    public function setWrapperComponent(Closure|CompoundComponent|BackendComponent|string $wrapperComponent): static;

    public function getWrapperComponent(): Closure|CompoundComponent|BackendComponent|string|null;
}
