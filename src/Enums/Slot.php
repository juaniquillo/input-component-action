<?php

declare(strict_types=1);

namespace Juaniquillo\InputComponentAction\Enums;

use Juaniquillo\BackendComponents\Enums\ComponentEnum;

enum Slot: string
{
    case WRAPPER = 'wrapper';

    case LABEL = 'label';

    case INPUT = 'input';

    case ERROR = 'error';

    case HELP_TEXT = 'helpText';

    public function defaultType(): ComponentEnum
    {
        return match ($this) {
            self::WRAPPER => ComponentEnum::DIV,
            self::LABEL => ComponentEnum::LABEL,
            self::INPUT => ComponentEnum::TEXT_INPUT,
            self::ERROR => ComponentEnum::PARAGRAPH,
            self::HELP_TEXT => ComponentEnum::DIV,
        };
    }
}
