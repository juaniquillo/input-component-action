<?php

declare(strict_types=1);

namespace Juaniquillo\InputComponentAction\Contracts;

use Closure;

interface ComponentBag
{
    public function setInputComponent(Closure|string $inputComponent): static;

    public function getInputComponent(): Closure|string|null;
}
