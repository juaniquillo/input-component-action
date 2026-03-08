<?php

declare(strict_types=1);

namespace Juaniquillo\InputComponentAction\Concerns;

use Closure;
use Juaniquillo\BackendComponents\Contracts\BackendComponent;
use Juaniquillo\BackendComponents\Contracts\CompoundComponent;
use Juaniquillo\BackendComponents\Contracts\StaticBuilder;

trait IsComponentBag
{
    private Closure|CompoundComponent|BackendComponent|string|null $inputComponent = null;

    public function setInputComponent(Closure|CompoundComponent|BackendComponent|string $inputComponent): static
    {
        $this->inputComponent = $inputComponent;

        return $this;
    }

    public function getInputComponent(): Closure|CompoundComponent|BackendComponent|string|null
    {
        return $this->inputComponent;
    }
}
