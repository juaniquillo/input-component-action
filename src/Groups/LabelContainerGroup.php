<?php

declare(strict_types=1);

namespace Juaniquillo\InputComponentAction\Groups;

use Juaniquillo\InputComponentAction\Enums\Slot;

final class LabelContainerGroup extends AbstractInputGroup
{
    protected array $slots = [Slot::LABEL, Slot::INPUT, Slot::ERROR];

    protected bool $labelWrapsInput = true;

    protected bool $requiresLabel = true;
}
