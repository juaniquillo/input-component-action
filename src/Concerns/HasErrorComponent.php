<?php

declare(strict_types=1);

namespace Juaniquillo\InputComponentAction\Concerns;

use Closure;

trait HasErrorComponent
{
    private Closure|string|null $errorComponent = null;

    public function setErrorComponent(Closure|string $errorComponent): static
    {
        $this->errorComponent = $errorComponent;

        return $this;
    }

    public function getErrorComponent(): Closure|string|null
    {
        return $this->errorComponent;
    }
}
