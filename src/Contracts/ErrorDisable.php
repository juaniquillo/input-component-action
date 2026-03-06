<?php

declare(strict_types=1);

namespace Juaniquillo\InputComponentAction\Contracts;

interface ErrorDisable
{
    public function setDisableError(bool $disableError = true): self;

    public function disableError(): bool;
}
