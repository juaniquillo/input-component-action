<?php

declare(strict_types=1);

namespace Juaniquillo\InputComponentAction\Concerns;

use Closure;
use Juaniquillo\BackendComponents\Contracts\BackendComponent;
use Juaniquillo\BackendComponents\Contracts\CompoundComponent;
use Juaniquillo\BackendComponents\Contracts\StaticBuilder;

trait HasErrorComponent
{
    private Closure|CompoundComponent|BackendComponent|string|null $errorComponent = null;

    public function setErrorComponent(Closure|CompoundComponent|BackendComponent|string $errorComponent): static
    {
        $this->errorComponent = $errorComponent;

        return $this;
    }

    public function getErrorComponent(): Closure|CompoundComponent|BackendComponent|string|null
    {
        return $this->errorComponent;
    }
}
