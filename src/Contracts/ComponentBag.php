<?php

declare(strict_types=1);

namespace Juaniquillo\InputComponentAction\Contracts;

use Juaniquillo\BackendComponents\Contracts\CompoundComponent;
use Juaniquillo\BackendComponents\Contracts\StaticBuilder;
use Closure;

interface ComponentBag
{
    public function setInputComponent(Closure|CompoundComponent|StaticBuilder $inputComponent): static;

    public function getInputComponent(): Closure|CompoundComponent|StaticBuilder|null;
}
