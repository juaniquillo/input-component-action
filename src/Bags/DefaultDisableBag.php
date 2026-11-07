<?php

declare(strict_types=1);

namespace Juaniquillo\InputComponentAction\Bags;

use Juaniquillo\InputComponentAction\Concerns\IsDisableBag;
use Juaniquillo\InputComponentAction\Contracts\DisableBag;

final class DefaultDisableBag implements DisableBag
{
    use IsDisableBag;
}
