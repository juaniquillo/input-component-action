<?php

declare(strict_types=1);

namespace Juaniquillo\InputComponentAction\Contracts;

interface InputDisable
{
    public function setDisableInputValue(bool $disableInputValue = true): self;

    public function disableInputValue(): bool;

    public function setDisableDefaultNameAttribute(bool $disableDefaultNameAttribute = true): self;

    public function disableDefaultNameAttribute(): bool;

    public function setDisableDefaultIdAttribute(bool $disableDefaultIdAttribute = true): self;

    public function disableDefaultIdAttribute(): bool;
}
