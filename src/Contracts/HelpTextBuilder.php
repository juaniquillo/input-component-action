<?php

declare(strict_types=1);

namespace Juaniquillo\InputComponentAction\Contracts;

use Juaniquillo\BackendComponents\Contracts\StaticBuilder;

interface HelpTextBuilder
{
    public function setHelpTextBuilder(StaticBuilder $helpTextBuilder): static;

    public function getHelpTextBuilder(): ?StaticBuilder;
}
