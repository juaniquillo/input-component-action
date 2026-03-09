<?php

declare(strict_types=1);

namespace Juaniquillo\InputComponentAction\Concerns;

use Closure;

trait HasLabelComponent
{
    private Closure|string|null $labelComponent = null;

    public function setLabelComponent(Closure|string $labelComponent): static
    {
        $this->labelComponent = $labelComponent;

        return $this;
    }

    public function getLabelComponent(): Closure|string|null
    {
        return $this->labelComponent;
    }
}
