<?php

declare(strict_types=1);

namespace Juaniquillo\InputComponentAction\Contracts;

use Closure;

interface LabelHook
{
    public function setLabelHook(Closure $labelHook): static;

    public function getLabelHook(): ?Closure;
}
