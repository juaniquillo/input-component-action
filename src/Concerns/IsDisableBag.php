<?php

declare(strict_types=1);

namespace Juaniquillo\InputComponentAction\Concerns;

trait IsDisableBag
{
    private bool $disableWrapper = false;

    private bool $disableLabel = false;

    private bool $disableDefaultForAttribute = false;

    private bool $disableError = false;

    private bool $disableHelpText = false;

    private bool $disableInputValue = false;

    private bool $disableDefaultNameAttribute = false;

    private bool $disableDefaultIdAttribute = false;

    public function setDisableWrapper(bool $disableWrapper = true): self
    {
        $this->disableWrapper = $disableWrapper;

        return $this;
    }

    public function disableWrapper(): bool
    {
        return $this->disableWrapper;
    }

    public function setDisableLabel(bool $disableLabel = true): self
    {
        $this->disableLabel = $disableLabel;

        return $this;
    }

    public function disableLabel(): bool
    {
        return $this->disableLabel;
    }

    public function setDisableDefaultForAttribute(bool $disableDefaultForAttribute = true): self
    {
        $this->disableDefaultForAttribute = $disableDefaultForAttribute;

        return $this;
    }

    public function disableDefaultForAttribute(): bool
    {
        return $this->disableDefaultForAttribute;
    }

    public function setDisableError(bool $disableError = true): self
    {
        $this->disableError = $disableError;

        return $this;
    }

    public function disableError(): bool
    {
        return $this->disableError;
    }

    public function setDisableHelpText(bool $disableHelpText = true): self
    {
        $this->disableHelpText = $disableHelpText;

        return $this;
    }

    public function disableHelpText(): bool
    {
        return $this->disableHelpText;
    }

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
