<?php

declare(strict_types=1);

namespace Juaniquillo\InputComponentAction\Contracts;

interface LabelDisable
{
    public function setDisableLabel(bool $disableLabel): self;

    public function disableLabel(): bool;

    public function setDisableDefaultForAttribute(bool $disableDefaultForAttribute = true): self;

    public function disableDefaultForAttribute(): bool;
}
