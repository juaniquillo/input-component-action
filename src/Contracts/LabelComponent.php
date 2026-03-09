<?php

declare(strict_types=1);

namespace Juaniquillo\InputComponentAction\Contracts;

use Closure;

interface LabelComponent
{
    public function setLabelComponent(Closure|string $labelComponent): static;

    public function getLabelComponent(): Closure|string|null;
}
