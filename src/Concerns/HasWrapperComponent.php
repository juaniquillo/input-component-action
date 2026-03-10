<?php

declare(strict_types=1);

namespace Juaniquillo\InputComponentAction\Concerns;

use BackedEnum;
use Closure;

trait HasWrapperComponent
{
    private Closure|string|null $wrapperComponent = null;

    private string|BackedEnum|null $wrapperType = null;

    public function setWrapperComponent(Closure|string $wrapperComponent): static
    {
        $this->wrapperComponent = $wrapperComponent;

        return $this;
    }

    public function getWrapperComponent(): Closure|string|null
    {
        return $this->wrapperComponent;
    }

    public function setWrapperType(string|BackedEnum $wrapperType): static
    {
        $this->wrapperType = $wrapperType;

        return $this;
    }

    public function getWrapperType(): string|BackedEnum|null
    {
        return $this->wrapperType;
    }
}
