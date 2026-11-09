<?php

declare(strict_types=1);

namespace Juaniquillo\InputComponentAction\Contracts;

interface DisableBag
{
    public function setDisableWrapper(bool $disableWrapper = true): self;

    public function disableWrapper(): bool;

    public function setDisableLabel(bool $disableLabel = true): self;

    public function disableLabel(): bool;

    public function setDisableDefaultForAttribute(bool $disableDefaultForAttribute = true): self;

    public function disableDefaultForAttribute(): bool;

    public function setDisableError(bool $disableError = true): self;

    public function disableError(): bool;

    public function setDisableHelpText(bool $disableHelpText = true): self;

    public function disableHelpText(): bool;

    public function setDisableInputValue(bool $disableInputValue = true): self;

    public function disableInputValue(): bool;

    public function setDisableDefaultNameAttribute(bool $disableDefaultNameAttribute = true): self;

    public function disableDefaultNameAttribute(): bool;

    public function setDisableDefaultIdAttribute(bool $disableDefaultIdAttribute = true): self;

    public function disableDefaultIdAttribute(): bool;
}
