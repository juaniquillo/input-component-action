<?php

declare(strict_types=1);

namespace Juaniquillo\InputComponentAction\Contracts;

use Juaniquillo\BackendComponents\Contracts\StaticBuilder;

interface LabelBuilder
{
    public function setLabelBuilder(StaticBuilder $labelBuilder): static;

    public function getLabelBuilder(): ?StaticBuilder;
}
