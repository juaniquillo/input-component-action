<?php

declare(strict_types=1);

namespace Juaniquillo\InputComponentAction\Concerns;

use Closure;
use Juaniquillo\BackendComponents\Contracts\CompoundComponent;
use Juaniquillo\BackendComponents\Contracts\StaticBuilder;

trait IsComponentBag
{
    private Closure|CompoundComponent|null $inputComponent = null;

    public function setInputComponent(Closure|CompoundComponent|StaticBuilder $inputComponent): static
    {
        $this->inputComponent = $inputComponent;

        return $this;
    }

    public function getInputComponent(): Closure|CompoundComponent|StaticBuilder|null
    {
        return $this->inputComponent;
    }
}
