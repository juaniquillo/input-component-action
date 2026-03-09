<?php

declare(strict_types=1);

namespace Juaniquillo\InputComponentAction\Concerns;

use Closure;

trait HasHelpTextComponent
{
    private Closure|string|null $helpTextComponent = null;

    public function setHelpTextComponent(Closure|string $helpTextComponent): static
    {
        $this->helpTextComponent = $helpTextComponent;

        return $this;
    }

    public function getHelpTextComponent(): Closure|string|null
    {
        return $this->helpTextComponent;
    }
}
