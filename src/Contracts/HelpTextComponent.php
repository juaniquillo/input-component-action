<?php

declare(strict_types=1);

namespace Juaniquillo\InputComponentAction\Contracts;

use BackedEnum;
use Closure;

interface HelpTextComponent
{
    public function setHelpTextComponent(Closure|string $helpTextComponent): static;

    public function getHelpTextComponent(): Closure|string|null;

    public function setHelpTextType(string|BackedEnum $helpTextType): static;

    public function getHelpTextType(): string|BackedEnum|null;
}
