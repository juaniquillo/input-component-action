<?php

declare(strict_types=1);

namespace Juaniquillo\InputComponentAction\Bags;

use Juaniquillo\InputComponentAction\Concerns\HasErrorComponent;
use Juaniquillo\InputComponentAction\Concerns\HasHelpTextComponent;
use Juaniquillo\InputComponentAction\Concerns\HasLabelComponent;
use Juaniquillo\InputComponentAction\Concerns\HasWrapperComponent;
use Juaniquillo\InputComponentAction\Concerns\IsComponentBag;
use Juaniquillo\InputComponentAction\Contracts\ComponentBag;
use Juaniquillo\InputComponentAction\Contracts\ErrorComponent;
use Juaniquillo\InputComponentAction\Contracts\HelpTextComponent;
use Juaniquillo\InputComponentAction\Contracts\LabelComponent;
use Juaniquillo\InputComponentAction\Contracts\WrapperComponent;

final class DefaultComponentBag implements ComponentBag, ErrorComponent, HelpTextComponent, LabelComponent, WrapperComponent
{
    use HasErrorComponent,
        HasHelpTextComponent,
        HasLabelComponent,
        HasWrapperComponent,
        IsComponentBag;
}
