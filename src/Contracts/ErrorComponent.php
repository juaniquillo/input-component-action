<?php

declare(strict_types=1);

namespace Juaniquillo\InputComponentAction\Contracts;

use Closure;
use Juaniquillo\BackendComponents\Contracts\BackendComponent;
use Juaniquillo\BackendComponents\Contracts\CompoundComponent;
use Juaniquillo\BackendComponents\Contracts\StaticBuilder;

interface ErrorComponent
{
    public function setErrorComponent(Closure|CompoundComponent|BackendComponent|string $errorComponent): static;

    public function getErrorComponent(): Closure|CompoundComponent|BackendComponent|string|null;
}
