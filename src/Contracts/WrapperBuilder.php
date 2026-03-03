<?php

declare(strict_types=1);

namespace Juaniquillo\InputComponentAction\Contracts;

use Juaniquillo\BackendComponents\Contracts\StaticBuilder;

interface WrapperBuilder
{
    public function setWrapperBuilder(StaticBuilder $wrapperBuilder): static;

    public function getWrapperBuilder(): ?StaticBuilder;
}
