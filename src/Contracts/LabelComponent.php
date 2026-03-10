<?php

declare(strict_types=1);

namespace Juaniquillo\InputComponentAction\Contracts;

use BackedEnum;
use Closure;

interface LabelComponent
{
    public function setLabelComponent(Closure|string $labelComponent): static;

    public function getLabelComponent(): Closure|string|null;

    public function setLabelType(string|BackedEnum $labelType): static;

    public function getLabelType(): string|BackedEnum|null;
}
