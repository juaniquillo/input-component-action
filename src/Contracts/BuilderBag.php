<?php

declare(strict_types=1);

namespace Juaniquillo\InputComponentAction\Contracts;

use Juaniquillo\BackendComponents\Contracts\StaticBuilder;

interface BuilderBag
{
    public function setInputBuilder(StaticBuilder $inputBuilder): static;

    public function getInputBuilder(): ?StaticBuilder;
}
