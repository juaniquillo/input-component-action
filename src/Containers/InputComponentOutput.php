<?php

declare(strict_types=1);

namespace Juaniquillo\InputComponentAction\Containers;

use Juaniquillo\CrudAssistant\Concerns\IsDataContainer;
use Juaniquillo\CrudAssistant\Contracts\DataContainerInterface;
use Juaniquillo\CrudAssistant\DataContainer;

/**
 * @implements DataContainerInterface<mixed>
 */
final class InputComponentOutput implements DataContainerInterface
{
    use IsDataContainer;

    public DataContainer $inputs;

    public DataContainer $meta;
}
