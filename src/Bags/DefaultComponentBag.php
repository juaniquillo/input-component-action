<?php

declare(strict_types=1);

namespace Juaniquillo\InputComponentAction\Bags;

use Juaniquillo\InputComponentAction\Concerns\IsComponentBag;
use Juaniquillo\InputComponentAction\Contracts\ComponentBag;

final class DefaultComponentBag implements ComponentBag
{
    use IsComponentBag;
}
