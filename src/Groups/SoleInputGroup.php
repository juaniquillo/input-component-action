<?php

declare(strict_types=1);

namespace Juaniquillo\InputComponentAction\Groups;

use Juaniquillo\InputComponentAction\Enums\Slot;

final class SoleInputGroup extends AbstractInputGroup
{
    protected array $slots = [Slot::INPUT];
}
