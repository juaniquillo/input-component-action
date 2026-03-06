<?php

declare(strict_types=1);

namespace Juaniquillo\InputComponentAction\Contracts;

interface HelpTextDisable
{
    public function setDisableHelpText(bool $disableHelpText = true): self;

    public function disableHelpText(): bool;
}
