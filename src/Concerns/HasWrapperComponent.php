<?php

declare(strict_types=1);

namespace Juaniquillo\InputComponentAction\Concerns;

use Closure;
use Juaniquillo\BackendComponents\Contracts\BackendComponent;
use Juaniquillo\BackendComponents\Contracts\CompoundComponent;
use Juaniquillo\BackendComponents\Contracts\StaticBuilder;

trait HasWrapperComponent
{
    private Closure|CompoundComponent|BackendComponent|string|null $wrapperComponent = null;

    public function setWrapperComponent(Closure|CompoundComponent|BackendComponent|string $wrapperComponent): static
    {
        $this->wrapperComponent = $wrapperComponent;

        return $this;
    }

    public function getWrapperComponent(): Closure|CompoundComponent|BackendComponent|string|null
    {
        return $this->wrapperComponent;
    }
}
