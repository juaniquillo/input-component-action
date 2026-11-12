<?php

declare(strict_types=1);

namespace Tests\Support;

use Juaniquillo\BaseBackendComponent\Contracts\BackendComponent;
use Juaniquillo\CrudAssistant\Contracts\InputCollectionInterface;
use Juaniquillo\InputComponentAction\Containers\InputComponentOutput;
use Juaniquillo\InputComponentAction\InputComponentAction;
use RuntimeException;

final class ActionFactory
{
    public static function make(array $values = [], array $errors = []): InputComponentAction
    {
        return new InputComponentAction($values, $errors);
    }

    public static function output(
        InputCollectionInterface $collection,
        ?InputComponentAction $action = null,
    ): InputComponentOutput {
        $action ??= self::make();

        $output = $collection->execute($action);

        if (! $output instanceof InputComponentOutput) {
            throw new RuntimeException('Expected an InputComponentOutput instance.');
        }

        return $output;
    }

    public static function component(
        InputCollectionInterface $collection,
        string $name,
        ?InputComponentAction $action = null,
    ): BackendComponent {
        $component = self::output($collection, $action)->inputs->get($name);

        if (! $component instanceof BackendComponent) {
            throw new RuntimeException("The [{$name}] output is not a backend component.");
        }

        return $component;
    }
}
