<?php

declare(strict_types=1);

namespace Juaniquillo\InputComponentAction\Containers;

use Juaniquillo\BackendComponents\Contracts\BackendComponent;
use Juaniquillo\BackendComponents\Contracts\ContentComponent;
use Juaniquillo\BackendComponents\Contracts\ThemeComponent;
use Juaniquillo\CrudAssistant\Concerns\IsDataContainer;
use Juaniquillo\CrudAssistant\Contracts\DataContainerInterface;
use Juaniquillo\CrudAssistant\DataContainer;

/**
 * @implements DataContainerInterface<mixed>
 */
final class InputComponentOutput implements DataContainerInterface
{
    /** @use IsDataContainer<mixed> */
    use IsDataContainer;

    /** @var DataContainer<BackendComponent&ContentComponent&ThemeComponent> */
    public DataContainer $inputs;

    /** @var DataContainer<mixed> */
    public DataContainer $meta;
}
