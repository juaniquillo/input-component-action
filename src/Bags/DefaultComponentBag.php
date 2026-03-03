<?php

declare(strict_types=1);

namespace Bags;

use Juaniquillo\InputComponentAction\Concerns\IsComponentBag;
use Juaniquillo\InputComponentAction\Contracts\ComponentBag;

class DefaultComponentBag implements ComponentBag
{
    use IsComponentBag;
}
