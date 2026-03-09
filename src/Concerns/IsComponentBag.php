<?php

declare(strict_types=1);

namespace Juaniquillo\InputComponentAction\Concerns;

use Closure;

trait IsComponentBag
{
    private Closure|string|null $inputComponent = null;

    public function setInputComponent(Closure|string $inputComponent): static
    {
        $this->inputComponent = $inputComponent;

        return $this;
    }

    public function getInputComponent(): Closure|string|null
    {
        return $this->inputComponent;
    }
}
