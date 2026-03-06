<?php

declare(strict_types=1);

namespace Juaniquillo\InputComponentAction\Concerns;

trait HasWrapperDisable
{
    private bool $disableWrapper = false;

    public function setDisableWrapper(bool $disableWrapper = true): self
    {
        $this->disableWrapper = $disableWrapper;

        return $this;
    }

    public function disableWrapper(): bool
    {
        return $this->disableWrapper;
    }
}
