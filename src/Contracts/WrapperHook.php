<?php

declare(strict_types=1);

namespace Juaniquillo\InputComponentAction\Contracts;

use Closure;

interface WrapperHook
{
    public function setWrapperHook(Closure $wrapperHook): static;

    public function getWrapperHook(): ?Closure;
}
