<?php

declare(strict_types=1);

namespace Juaniquillo\InputComponentAction\Contracts;

use BackedEnum;
use Closure;

interface ComponentBag
{
    public function setInputComponent(Closure|string $inputComponent): static;

    public function getInputComponent(): Closure|string|null;

    public function setInputType(string|BackedEnum $inputType): static;

    public function getInputType(): string|BackedEnum|null;
}
