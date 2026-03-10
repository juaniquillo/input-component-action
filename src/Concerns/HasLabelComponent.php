<?php

declare(strict_types=1);

namespace Juaniquillo\InputComponentAction\Concerns;

use BackedEnum;
use Closure;

trait HasLabelComponent
{
    private Closure|string|null $labelComponent = null;

    private string|BackedEnum|null $labelType = null;

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

    public function getLabelType(): string|BackedEnum|null
    {
        return $this->labelType;
    }
}
