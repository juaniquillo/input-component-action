<?php

declare(strict_types=1);

namespace Juaniquillo\InputComponentAction\Enums;

use BackedEnum;
use Juaniquillo\InputComponentAction\Defaults\InputTypes;

enum Slot: string
{
    case WRAPPER = 'wrapper';

    case LABEL = 'label';

    case INPUT = 'input';

    case ERROR = 'error';

    case HELP_TEXT = 'helpText';

    public function defaultType(): BackedEnum
    {
        return match ($this) {
            self::WRAPPER => InputTypes::WRAPPER,
            self::LABEL => InputTypes::LABEL,
            self::INPUT => InputTypes::INPUT,
            self::ERROR => InputTypes::ERROR,
            self::HELP_TEXT => InputTypes::HELP_TEXT,
        };
    }
}
