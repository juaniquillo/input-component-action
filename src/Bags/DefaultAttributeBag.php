<?php

declare(strict_types=1);

namespace Juaniquillo\InputComponentAction\Bags;

use Juaniquillo\InputComponentAction\Concerns\IsAttributeBag;
use Juaniquillo\InputComponentAction\Contracts\AttributeBag;

final class DefaultAttributeBag implements AttributeBag
{
    use IsAttributeBag;
}
