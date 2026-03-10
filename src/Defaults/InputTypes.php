<?php

declare(strict_types=1);

namespace Juaniquillo\InputComponentAction\Defaults;

use Juaniquillo\BackendComponents\Enums\ComponentEnum;

final class InputTypes
{
    const WRAPPER = ComponentEnum::DIV;

    const INPUT = ComponentEnum::TEXT_INPUT;

    const LABEL = ComponentEnum::LABEL;

    const ERROR = ComponentEnum::PARAGRAPH;

    const HELP_TEXT = ComponentEnum::DIV;
}
