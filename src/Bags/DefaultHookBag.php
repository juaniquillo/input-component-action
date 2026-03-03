<?php

declare(strict_types=1);

namespace Juaniquillo\InputComponentAction\Bags;

use Juaniquillo\InputComponentAction\Concerns\HasErrorHook;
use Juaniquillo\InputComponentAction\Concerns\HasHelpTextHook;
use Juaniquillo\InputComponentAction\Concerns\HasLabelHook;
use Juaniquillo\InputComponentAction\Concerns\HasWrapperHook;
use Juaniquillo\InputComponentAction\Concerns\IsHookBag;
use Juaniquillo\InputComponentAction\Contracts\ErrorHook;
use Juaniquillo\InputComponentAction\Contracts\HelpTextHook;
use Juaniquillo\InputComponentAction\Contracts\HookBag;
use Juaniquillo\InputComponentAction\Contracts\LabelHook;
use Juaniquillo\InputComponentAction\Contracts\WrapperHook;

final class DefaultHookBag implements ErrorHook, HelpTextHook, HookBag, LabelHook, WrapperHook
{
    use HasErrorHook,
        HasHelpTextHook,
        HasLabelHook,
        HasWrapperHook,
        IsHookBag;
}
