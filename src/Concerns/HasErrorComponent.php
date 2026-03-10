<?php

declare(strict_types=1);

namespace Juaniquillo\InputComponentAction\Concerns;

use BackedEnum;
use Closure;
use Juaniquillo\BackendComponents\Enums\ComponentEnum;

trait HasErrorComponent
{
    private Closure|string|null $errorComponent = null;

    private string|BackedEnum $errorType = ComponentEnum::PARAGRAPH;

    public function setErrorComponent(Closure|string $errorComponent): static
    {
        $this->errorComponent = $errorComponent;

        return $this;
    }

    public function getErrorComponent(): Closure|string|null
    {
        return $this->errorComponent;
    }

    public function setErrorType(string|BackedEnum $errorType): static
    {
        $this->errorType = $errorType;

        return $this;
    }

    public function getErrorType(): string|BackedEnum
    {
        return $this->errorType;
    }
}
