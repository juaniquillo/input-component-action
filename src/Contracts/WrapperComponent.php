<?php

declare(strict_types=1);

namespace Juaniquillo\InputComponentAction\Contracts;

use BackedEnum;
use Closure;

interface WrapperComponent
{
    public function setWrapperComponent(Closure|string $wrapperComponent): static;

    public function getWrapperComponent(): Closure|string|null;

    public function setWrapperType(string|BackedEnum $wrapperType): static;

    public function getWrapperType(): string|BackedEnum|null;
}
