<?php

declare(strict_types=1);

namespace Juaniquillo\InputComponentAction\Groups;

use Juaniquillo\InputComponentAction\Enums\Slot;

final class LabelHelpTextInputErrorGroup extends AbstractInputGroup
{
    protected array $slots = [Slot::LABEL, Slot::HELP_TEXT, Slot::INPUT, Slot::ERROR];
}
