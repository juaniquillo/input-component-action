<?php

declare(strict_types=1);

namespace Juaniquillo\InputComponentAction\Containers;

use ArrayAccess;
use Juaniquillo\CrudAssistant\Concerns\IsDataContainer;
use Juaniquillo\CrudAssistant\Contracts\DataContainerInterface;
use Juaniquillo\CrudAssistant\DataContainer;
use Countable;
use IteratorAggregate;

final class InputComponentOutput implements ArrayAccess, Countable, DataContainerInterface, IteratorAggregate
{
    use IsDataContainer;

    public DataContainer $inputs;

    public DataContainer $meta;
}
