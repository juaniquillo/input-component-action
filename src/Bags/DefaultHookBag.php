<?php

declare(strict_types=1);

namespace Juaniquillo\InputComponentAction\Bags;

use Juaniquillo\InputComponentAction\Concerns\IsHookBag;
use Juaniquillo\InputComponentAction\Contracts\HookBag;

final class DefaultHookBag implements HookBag
{
    use IsHookBag;
}
