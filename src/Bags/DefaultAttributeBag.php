<?php

declare(strict_types=1);

namespace Juaniquillo\InputComponentAction\Bags;

use Juaniquillo\InputComponentAction\Concerns\HasErrorAttributes;
use Juaniquillo\InputComponentAction\Concerns\HasHelpTextAttributes;
use Juaniquillo\InputComponentAction\Concerns\HasLabelAttributes;
use Juaniquillo\InputComponentAction\Concerns\HasWrapperAttributes;
use Juaniquillo\InputComponentAction\Concerns\IsAttributeBag;
use Juaniquillo\InputComponentAction\Contracts\AttributeBag;
use Juaniquillo\InputComponentAction\Contracts\ErrorAttributes;
use Juaniquillo\InputComponentAction\Contracts\HelpTextAttributes;
use Juaniquillo\InputComponentAction\Contracts\LabelAttributes;
use Juaniquillo\InputComponentAction\Contracts\WrapperAttributes;

final class DefaultAttributeBag implements AttributeBag, ErrorAttributes, HelpTextAttributes, LabelAttributes, WrapperAttributes
{
    use HasErrorAttributes,
        HasHelpTextAttributes,
        HasLabelAttributes,
        HasWrapperAttributes,
        IsAttributeBag;
}
