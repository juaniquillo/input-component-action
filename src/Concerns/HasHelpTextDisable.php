<?php

declare(strict_types=1);

namespace Juaniquillo\InputComponentAction\Concerns;

trait HasHelpTextDisable
{
    private bool $disableHelpText = false;

    public function setDisableHelpText(bool $disableHelpText = true): self
    {
        $this->disableHelpText = $disableHelpText;

        return $this;
    }

    public function disableHelpText(): bool
    {
        return $this->disableHelpText;
    }
}
