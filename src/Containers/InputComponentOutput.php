<?php

declare(strict_types=1);

namespace Juaniquillo\InputComponentAction\Containers;

use Juaniquillo\BaseBackendComponent\Contracts\BackendComponent;
use Juaniquillo\BaseBackendComponent\Contracts\ContentComponent;
use Juaniquillo\BaseBackendComponent\Contracts\ThemeComponent;
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
