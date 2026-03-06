<?php

declare(strict_types=1);

namespace Juaniquillo\InputComponentAction\Concerns;

trait HasInputDisable
{
    private bool $disableInputValue = false;

    private bool $disableDefaultNameAttribute = false;

    private bool $disableDefaultIdAttribute = false;

    public function setDisableInputValue(bool $disableInputValue = true): self
    {
        $this->disableInputValue = $disableInputValue;

        return $this;
    }

    public function disableInputValue(): bool
    {
        return $this->disableInputValue;
    }

    public function setDisableDefaultNameAttribute(bool $disableDefaultNameAttribute = true): self
    {
        $this->disableDefaultNameAttribute = $disableDefaultNameAttribute;

        return $this;
    }

    public function disableDefaultNameAttribute(): bool
    {
        return $this->disableDefaultNameAttribute;
    }

    public function setDisableDefaultIdAttribute(bool $disableDefaultIdAttribute = true): self
    {
        $this->disableDefaultIdAttribute = $disableDefaultIdAttribute;

        return $this;
    }

    public function disableDefaultIdAttribute(): bool
    {
        return $this->disableDefaultIdAttribute;
    }
}
