<?php

declare(strict_types=1);

namespace Juaniquillo\InputComponentAction\Bags;

use Juaniquillo\InputComponentAction\Concerns\IsComposerDisableBag;
use Juaniquillo\InputComponentAction\Contracts\ComposerDisableBag;
use Juaniquillo\InputComponentAction\Contracts\ErrorDisable;
use Juaniquillo\InputComponentAction\Contracts\HelpTextDisable;
use Juaniquillo\InputComponentAction\Contracts\InputDisable;
use Juaniquillo\InputComponentAction\Contracts\LabelDisable;
use Juaniquillo\InputComponentAction\Contracts\WrapperDisable;

final class DefaultDisableBag implements ComposerDisableBag, ErrorDisable, HelpTextDisable, InputDisable, LabelDisable, WrapperDisable
{
    use IsComposerDisableBag;
}
