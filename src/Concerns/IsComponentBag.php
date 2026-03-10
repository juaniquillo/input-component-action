<?php

declare(strict_types=1);

namespace Juaniquillo\InputComponentAction\Concerns;

use BackedEnum;
use Closure;
use Juaniquillo\BackendComponents\Enums\ComponentEnum;

trait IsComponentBag
{
    private Closure|string|null $inputComponent = null;

    private string|BackedEnum $inputType = ComponentEnum::TEXT_INPUT;

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

    public function getInputType(): string|BackedEnum
    {
        return $this->inputType;
    }
}
