<?php

declare(strict_types=1);

namespace Juaniquillo\InputComponentAction;

use Exception;
use Juaniquillo\CrudAssistant\Concerns\IsAction;
use Juaniquillo\CrudAssistant\Contracts\ActionInterface;
use Juaniquillo\CrudAssistant\Contracts\InputCollectionInterface;
use Juaniquillo\CrudAssistant\Contracts\InputInterface;
use Juaniquillo\CrudAssistant\DataContainer;
use Juaniquillo\InputComponentAction\Concerns\IsInputComponentAction;
use Juaniquillo\InputComponentAction\Containers\InputComponentOutput;
use Juaniquillo\InputComponentAction\Contracts\InputComponentActionInterface;

final class InputComponentAction implements ActionInterface, InputComponentActionInterface
{
    use IsAction,
        IsInputComponentAction;

    /**
     * @param  array<string|int, string|int|array<string|int|null>|null>  $values
     * @param  array<string, string|array<int, string>|null>  $errors
     */
    public function __construct(
        private array $values = [],
        private array $errors = [],
    ) {
        $this->controlsRecursion = true;
        $this->initOutput();
    }

    /**
     * @param  array<string|int, string|int|array<string|int|null>|null>  $values
     * @param  array<string, string|array<int, string>|null>  $errors
     */
    public static function make(array $values = [], array $errors = []): static
    {
        return new self(values: $values, errors: $errors);
    }

    public function initOutput(): static
    {
        if (! $this->output instanceof InputComponentOutput) {
            $this->output = new InputComponentOutput;

            $this->output->inputs = new DataContainer;
            $this->output->meta = new DataContainer;
        }

        return $this;
    }

    public function execute(InputCollectionInterface|InputInterface $input): void
    {
        /** @var InputComponentOutput $output */
        $output = $this->getOutput();
        $inputs = $output->inputs;

        $name = $input->getName();

        if (! $name) {
            throw new Exception(message: 'The Input '.$input::class.' must have a name', code: 500);
        }

        $inputs->set($name, $this->resolveInputs($input));
    }
}
