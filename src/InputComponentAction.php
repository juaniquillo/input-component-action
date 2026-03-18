<?php

declare(strict_types=1);

namespace Juaniquillo\InputComponentAction;

use Exception;
use Juaniquillo\CrudAssistant\Concerns\IsAction;
use Juaniquillo\CrudAssistant\Contracts\ActionInterface;
use Juaniquillo\CrudAssistant\Contracts\InputInterface;
use Juaniquillo\CrudAssistant\DataContainer;
use Juaniquillo\CrudAssistant\InputCollection;
use Juaniquillo\InputComponentAction\Concerns\IsInputComponentAction;
use Juaniquillo\InputComponentAction\Containers\InputComponentOutput;
use Juaniquillo\InputComponentAction\Contracts\InputComponentActionInterface;

final class InputComponentAction implements ActionInterface, InputComponentActionInterface
{
    use IsAction,
        IsInputComponentAction;

    protected $controlsRecursion = true;

    public function __construct(
        private array $values = [],
        private array $errors = [],
    ) {
        $this->output = new InputComponentOutput;

        $this->output->inputs = new DataContainer;
        $this->output->meta = new DataContainer;
    }

    public static function make(array $values = [], array $errors = []): static
    {
        return new self(values: $values, errors: $errors);
    }

    public function execute(InputCollection|InputInterface|\IteratorAggregate $input)
    {
        /** @var InputComponentOutput $output */
        $output = $this->output;
        $inputs = $output->inputs;

        $name = $input->getName();

        if (! $name) {
            throw new Exception(message: 'The Input '.$input::class.' must have a name', code: 500);
        }

        $inputs->set($name, $this->resolveInputs($input));

        return $this->output;
    }
}
