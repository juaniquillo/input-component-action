<?php

declare(strict_types=1);

namespace Juaniquillo\InputComponentAction\Concerns;

use BackedEnum;
use Closure;
use Juaniquillo\BackendComponents\Enums\ComponentEnum;

trait HasHelpTextComponent
{
    private Closure|string|null $helpTextComponent = null;

    private string|BackedEnum $helpTextType = ComponentEnum::PARAGRAPH;

    public function setHelpTextComponent(Closure|string $helpTextComponent): static
    {
        $this->helpTextComponent = $helpTextComponent;

        return $this;
    }

    public function getHelpTextComponent(): Closure|string|null
    {
        return $this->helpTextComponent;
    }

    public function setHelpTextType(string|BackedEnum $helpTextType): static
    {
        $this->helpTextType = $helpTextType;

        return $this;
    }

    public function getHelpTextType(): string|BackedEnum
    {
        return $this->helpTextType;
    }
}
