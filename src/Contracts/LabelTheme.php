<?php

declare(strict_types=1);

namespace Juaniquillo\InputComponentAction\Contracts;

use Closure;

interface LabelTheme
{
    public function setLabelTheme(Closure|array $labelTheme): static;

    public function getLabelTheme(): Closure|array|null;
}
