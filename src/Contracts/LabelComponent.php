<?php

declare(strict_types=1);

namespace Juaniquillo\InputComponentAction\Contracts;

use Closure;
use Juaniquillo\BackendComponents\Contracts\BackendComponent;
use Juaniquillo\BackendComponents\Contracts\CompoundComponent;
use Juaniquillo\BackendComponents\Contracts\StaticBuilder;

interface LabelComponent
{
    public function setLabelComponent(Closure|CompoundComponent|BackendComponent|string $labelComponent): static;

    public function getLabelComponent(): Closure|CompoundComponent|BackendComponent|string|null;
}
