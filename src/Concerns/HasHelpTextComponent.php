<?php

declare(strict_types=1);

namespace Juaniquillo\InputComponentAction\Concerns;

use Closure;
use Juaniquillo\BackendComponents\Contracts\BackendComponent;
use Juaniquillo\BackendComponents\Contracts\CompoundComponent;
use Juaniquillo\BackendComponents\Contracts\StaticBuilder;

trait HasHelpTextComponent
{
    private Closure|CompoundComponent|BackendComponent|string|null $helpTextComponent = null;

    public function setHelpTextComponent(Closure|CompoundComponent|BackendComponent|string $helpTextComponent): static
    {
        $this->helpTextComponent = $helpTextComponent;

        return $this;
    }

    public function getHelpTextComponent(): Closure|CompoundComponent|BackendComponent|string|null
    {
        return $this->helpTextComponent;
    }
}
