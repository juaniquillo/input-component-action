<?php

declare(strict_types=1);

namespace Juaniquillo\InputComponentAction\Concerns;

use BackedEnum;
use Closure;
use Juaniquillo\BackendComponents\Enums\ComponentEnum;

trait HasWrapperComponent
{
    private Closure|string|null $wrapperComponent = null;

    private string|BackedEnum $wrapperType = ComponentEnum::DIV;

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

    public function getWrapperType(): string|BackedEnum
    {
        return $this->wrapperType;
    }
}
