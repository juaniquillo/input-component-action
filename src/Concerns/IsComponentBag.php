<?php

declare(strict_types=1);

namespace Juaniquillo\InputComponentAction\Concerns;

use BackedEnum;
use Closure;

trait IsComponentBag
{
    private Closure|string|null $inputComponent = null;

    private string|BackedEnum|null $inputType = null;

    public function setInputComponent(Closure|string $inputComponent): static
    {
        $this->inputComponent = $inputComponent;

        return $this;
    }

    public function getInputComponent(): Closure|string|null
    {
        return $this->inputComponent;
    }

    public function setInputType(string|BackedEnum $inputType): static
    {
        $this->inputType = $inputType;

        return $this;
    }

    public function getInputType(): string|BackedEnum|null
    {
        return $this->inputType;
    }
}
