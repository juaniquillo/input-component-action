<?php

declare(strict_types=1);

namespace Juaniquillo\InputComponentAction\Concerns;

use BackedEnum;
use Closure;
use Juaniquillo\BackendComponents\Enums\ComponentEnum;

trait HasLabelComponent
{
    private Closure|string|null $labelComponent = null;

    private string|BackedEnum $labelType = ComponentEnum::LABEL;

    public function setLabelComponent(Closure|string $labelComponent): static
    {
        $this->labelComponent = $labelComponent;

        return $this;
    }

    public function getLabelComponent(): Closure|string|null
    {
        return $this->labelComponent;
    }

    public function setLabelType(string|BackedEnum $labelType): static
    {
        $this->labelType = $labelType;

        return $this;
    }

    public function getLabelType(): string|BackedEnum
    {
        return $this->labelType;
    }
}
