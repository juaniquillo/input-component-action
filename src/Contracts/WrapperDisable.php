<?php

declare(strict_types=1);

namespace Juaniquillo\InputComponentAction\Contracts;

interface WrapperDisable
{
    public function setDisableWrapper(bool $disableWrapper = true): self;

    public function disableWrapper(): bool;
}
