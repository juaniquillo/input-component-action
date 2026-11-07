<?php

declare(strict_types=1);

namespace Tests\Unit;

use Exception;
use Juaniquillo\BackendComponents\Enums\ComponentEnum;
use Juaniquillo\CrudAssistant\Contracts\InputInterface;
use Juaniquillo\CrudAssistant\CrudAssistant;
use Juaniquillo\CrudAssistant\DataContainer;
use Juaniquillo\CrudAssistant\Inputs\DefaultInput;
use Juaniquillo\InputComponentAction\Containers\InputComponentOutput;
use Juaniquillo\InputComponentAction\Contracts\ErrorManager;
use Juaniquillo\InputComponentAction\Contracts\InputComponentRecipeInterface;
use Juaniquillo\InputComponentAction\Contracts\ValueManager;
use Juaniquillo\InputComponentAction\Groups\SoleInputGroup;
use Juaniquillo\InputComponentAction\InputComponentAction;
use Juaniquillo\InputComponentAction\Managers\DefaultErrorManager;
use Juaniquillo\InputComponentAction\Managers\DefaultValueManager;
use Juaniquillo\InputComponentAction\Recipes\InputComponentRecipe;
use Stringable;
use Tests\Support\ActionFactory;
use Tests\Support\ComponentTree;

test('it can be created with make', function (): void {
    expect(InputComponentAction::make())->toBeInstanceOf(InputComponentAction::class);
});

test('it initializes the output container', function (): void {
    $output = (new InputComponentAction)->getOutput();

    expect($output)->toBeInstanceOf(InputComponentOutput::class)
        ->and($output->inputs)->toBeInstanceOf(DataContainer::class)
        ->and($output->meta)->toBeInstanceOf(DataContainer::class);
});

test('it returns the same output container on every call', function (): void {
    $action = new InputComponentAction;

    expect($action->getOutput())->toBe($action->getOutput())
        ->and($action->initOutput())->toBe($action);
});

test('it throws when an input has no name', function (): void {
    expect(static fn () => (new InputComponentAction)->execute(new DefaultInput))
        ->toThrow(Exception::class, 'must have a name');
});

test('it resolves the value manager using recipe, action and default priorities', function (): void {
    $model = (object) ['name' => 'model-value'];
    $actionBag = new DefaultValueManager;
    $recipeBag = new DefaultValueManager;

    $action = (new InputComponentAction(['name' => 'array-value']))
        ->setModel($model)
        ->setValueManager($actionBag);

    $fromAction = $action->getValueManager(null);

    expect($fromAction)->toBe($actionBag)
        ->and($fromAction->getValues())->toBe(['name' => 'array-value'])
        ->and($fromAction->getModel())->toBe($model);

    $recipe = new InputComponentRecipe(valueBag: $recipeBag);

    expect($action->getValueManager($recipe))->toBe($recipeBag)
        ->and($recipeBag->getValues())->toBe(['name' => 'array-value'])
        ->and($recipeBag->getModel())->toBe($model);
});

test('it falls back to the default value manager', function (): void {
    expect((new InputComponentAction)->getValueManager(null))
        ->toBeInstanceOf(DefaultValueManager::class);
});

test('it resolves the error manager using recipe, action and default priorities', function (): void {
    $actionBag = new DefaultErrorManager;
    $recipeBag = new DefaultErrorManager;

    $action = (new InputComponentAction(errors: ['name' => 'error']))->setErrorManager($actionBag);

    expect($action->getErrorManager(null))->toBe($actionBag)
        ->and($action->getErrorManager(null)->resolve(new DefaultInput('name'), new InputComponentRecipe))->toBe('error');

    $recipe = new InputComponentRecipe(errorBag: $recipeBag);

    expect($action->getErrorManager($recipe))->toBe($recipeBag);
});

test('it falls back to the default error manager', function (): void {
    expect((new InputComponentAction)->getErrorManager(null))
        ->toBeInstanceOf(DefaultErrorManager::class);
});

test('it uses a custom value manager when building components', function (): void {
    $manager = new class implements ValueManager
    {
        private array $values = [];

        private ?object $model = null;

        public function setValues(array $values): static
        {
            $this->values = $values;

            return $this;
        }

        public function getValues(): array
        {
            return $this->values;
        }

        public function setModel(?object $model): static
        {
            $this->model = $model;

            return $this;
        }

        public function getModel(): ?object
        {
            return $this->model;
        }

        public function resolve(InputInterface $input, InputComponentRecipeInterface $recipe, bool $ignoreRecipeValue = false): Stringable|string|int|array|null
        {
            return 'custom-'.$input->getName();
        }
    };

    $component = ActionFactory::component(
        CrudAssistant::make([new DefaultInput('name', 'Name')]),
        'name',
        ActionFactory::make()->setValueManager($manager),
    );
    $inputComponent = ComponentTree::find($component, ComponentEnum::TEXT_INPUT->value);

    expect($inputComponent->getAttribute('value'))->toBe('custom-name');
});

test('it uses a custom error manager when building components', function (): void {
    $manager = new class implements ErrorManager
    {
        private array $errors = [];

        public function setErrors(array $errors): static
        {
            $this->errors = $errors;

            return $this;
        }

        public function resolve(InputInterface $input, InputComponentRecipeInterface $recipe): ?string
        {
            return 'custom-'.$input->getName();
        }
    };

    $component = ActionFactory::component(
        CrudAssistant::make([new DefaultInput('name', 'Name')]),
        'name',
        ActionFactory::make()->setErrorManager($manager),
    );
    $children = array_values(ComponentTree::of($component)['contents']);

    expect($children[2]['contents'])->toBe(['custom-name']);
});

test('it uses the default input group from the action', function (): void {
    $component = ActionFactory::component(
        CrudAssistant::make([new DefaultInput('name', 'Name')]),
        'name',
        ActionFactory::make()->setDefaultInputGroup(SoleInputGroup::class),
    );
    $children = array_values(ComponentTree::of($component)['contents']);

    expect(array_column($children, 'type'))->toBe([ComponentEnum::TEXT_INPUT->value]);
});

test('it resolves the default input group from a closure', function (): void {
    $component = ActionFactory::component(
        CrudAssistant::make([new DefaultInput('name', 'Name')]),
        'name',
        ActionFactory::make()->setDefaultInputGroup(static fn () => new SoleInputGroup),
    );
    $children = array_values(ComponentTree::of($component)['contents']);

    expect(array_column($children, 'type'))->toBe([ComponentEnum::TEXT_INPUT->value]);
});
