<?php

declare(strict_types=1);

namespace Juaniquillo\InputComponentAction\Concerns;

trait HasErrorDisable
{
    private bool $disableError = false;

    public function setDisableError(bool $disableError = true): self
    {
        $this->disableError = $disableError;

        return $this;
    }

    public function disableError(): bool
    {
        return $this->disableError;
    }
}
