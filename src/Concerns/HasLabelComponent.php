<?php

declare(strict_types=1);

namespace Juaniquillo\InputComponentAction\Concerns;

use Closure;
use Juaniquillo\BackendComponents\Contracts\BackendComponent;
use Juaniquillo\BackendComponents\Contracts\CompoundComponent;
use Juaniquillo\BackendComponents\Contracts\StaticBuilder;

trait HasLabelComponent
{
    private Closure|CompoundComponent|BackendComponent|string|null $labelComponent = null;

    public function setLabelComponent(Closure|CompoundComponent|BackendComponent|string $labelComponent): static
    {
        $this->labelComponent = $labelComponent;

        return $this;
    }

    public function getLabelComponent(): Closure|CompoundComponent|BackendComponent|string|null
    {
        return $this->labelComponent;
    }
}
