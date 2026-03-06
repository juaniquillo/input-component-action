<?php

declare(strict_types=1);

namespace Juaniquillo\InputComponentAction\Concerns;

trait HasLabelDisable
{
    private bool $disableLabel = false;

    private bool $disableDefaultForAttribute = false;

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
}
