<?php

declare(strict_types=1);

namespace Juaniquillo\InputComponentAction\Contracts;

use Closure;

interface LabelAttributes
{
    public function setLabelAttributes(Closure|array $labelTheme): static;

    public function getLabelAttributes(): Closure|array|null;
}
