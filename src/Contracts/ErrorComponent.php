<?php

declare(strict_types=1);

namespace Juaniquillo\InputComponentAction\Contracts;

use BackedEnum;
use Closure;

interface ErrorComponent
{
    public function setErrorComponent(Closure|string $errorComponent): static;

    public function getErrorComponent(): Closure|string|null;

    public function setErrorType(string|BackedEnum $errorType): static;

    public function getErrorType(): string|BackedEnum;
}
