<?php

declare(strict_types=1);

namespace Juaniquillo\InputComponentAction\Contracts;

use Juaniquillo\BackendComponents\Contracts\StaticBuilder;

interface ErrorBuilder
{
    public function setErrorBuilder(StaticBuilder $errorBuilder): static;

    public function getErrorBuilder(): ?StaticBuilder;
}
