<?php

declare(strict_types=1);

namespace Juaniquillo\InputComponentAction\Concerns;

trait IsComposerDisableBag
{
    use HasErrorDisable,
        HasHelpTextDisable,
        HasInputDisable,
        HasLabelDisable,
        HasWrapperDisable;
}
