<?php

declare(strict_types=1);

namespace Juaniquillo\InputComponentAction\Concerns;

trait IsDisableBag
{
    use HasErrorDisable,
        HasHelpTextDisable,
        HasInputDisable,
        HasLabelDisable,
        HasWrapperDisable;
}
