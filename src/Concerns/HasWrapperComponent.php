<?php

declare(strict_types=1);

namespace Juaniquillo\InputComponentAction\Concerns;

use Closure;

trait HasWrapperComponent
{
    private Closure|string|null $wrapperComponent = null;

    public function setWrapperComponent(Closure|string $wrapperComponent): static
    {
        $this->wrapperComponent = $wrapperComponent;

        return $this;
    }

    public function getWrapperComponent(): Closure|string|null
    {
        return $this->wrapperComponent;
    }
}
