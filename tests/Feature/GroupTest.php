<?php

declare(strict_types=1);

namespace Tests\Feature;

use Exception;
use Juaniquillo\BackendComponents\Enums\ComponentEnum;
use Juaniquillo\CrudAssistant\CrudAssistant;
use Juaniquillo\CrudAssistant\Inputs\DefaultInput;
use Juaniquillo\InputComponentAction\Bags\DefaultDisableBag;
use Juaniquillo\InputComponentAction\Groups\DefaultInputGroup;
use Juaniquillo\InputComponentAction\Groups\InputErrorGroup;
use Juaniquillo\InputComponentAction\Groups\InputLabelErrorGroup;
use Juaniquillo\InputComponentAction\Groups\LabelContainerGroup;
use Juaniquillo\InputComponentAction\Groups\LabelHelpTextInputErrorGroup;
use Juaniquillo\InputComponentAction\Groups\NoWrapInputGroup;
use Juaniquillo\InputComponentAction\Groups\NoWrapSoleInputGroup;
use Juaniquillo\InputComponentAction\Groups\SoleInputGroup;
use Juaniquillo\InputComponentAction\Recipes\InputComponentRecipe;
use Tests\Support\ActionFactory;
use Tests\Support\ComponentTree;

test('the default input group renders label, input and error', function (): void {
    $input = new DefaultInput('name', 'Name');
    $input->setRecipe(new InputComponentRecipe(inputGroup: new DefaultInputGroup, helpText: 'Some help'));

    $component = ActionFactory::component(
        CrudAssistant::make([$input]),
        'name',
        ActionFactory::make(errors: ['name' => 'Too short']),
    );
    $children = array_values(ComponentTree::of($component)['contents']);

    expect($component->getName())->toBe(ComponentEnum::DIV->value)
        ->and(array_column($children, 'type'))->toBe([
            ComponentEnum::LABEL->value,
            ComponentEnum::TEXT_INPUT->value,
            ComponentEnum::PARAGRAPH->value,
        ]);
});

test('the input label error group renders input, label and error', function (): void {
    $input = new DefaultInput('name', 'Name');
    $input->setRecipe(new InputComponentRecipe(inputGroup: new InputLabelErrorGroup));

    $component = ActionFactory::component(
        CrudAssistant::make([$input]),
        'name',
        ActionFactory::make(errors: ['name' => 'Too short']),
    );
    $children = array_values(ComponentTree::of($component)['contents']);

    expect(array_column($children, 'type'))->toBe([
        ComponentEnum::TEXT_INPUT->value,
        ComponentEnum::LABEL->value,
        ComponentEnum::PARAGRAPH->value,
    ]);
});

test('the input error group renders input and error', function (): void {
    $input = new DefaultInput('name', 'Name');
    $input->setRecipe(new InputComponentRecipe(inputGroup: new InputErrorGroup));

    $component = ActionFactory::component(
        CrudAssistant::make([$input]),
        'name',
        ActionFactory::make(errors: ['name' => 'Too short']),
    );
    $children = array_values(ComponentTree::of($component)['contents']);

    expect(array_column($children, 'type'))->toBe([
        ComponentEnum::TEXT_INPUT->value,
        ComponentEnum::PARAGRAPH->value,
    ]);
});

test('the label help text input error group renders every slot in order', function (): void {
    $input = new DefaultInput('name', 'Name');
    $input->setRecipe(new InputComponentRecipe(
        inputGroup: new LabelHelpTextInputErrorGroup,
        helpText: 'Some help',
    ));

    $component = ActionFactory::component(
        CrudAssistant::make([$input]),
        'name',
        ActionFactory::make(errors: ['name' => 'Too short']),
    );
    $children = array_values(ComponentTree::of($component)['contents']);

    expect(array_column($children, 'type'))->toBe([
        ComponentEnum::LABEL->value,
        ComponentEnum::DIV->value,
        ComponentEnum::TEXT_INPUT->value,
        ComponentEnum::PARAGRAPH->value,
    ])->and($children[1]['contents'])->toBe(['Some help'])
        ->and($children[3]['contents'])->toBe(['Too short']);
});

test('the label help text input error group skips a missing help text', function (): void {
    $input = new DefaultInput('name', 'Name');
    $input->setRecipe(new InputComponentRecipe(inputGroup: new LabelHelpTextInputErrorGroup));

    $component = ActionFactory::component(
        CrudAssistant::make([$input]),
        'name',
        ActionFactory::make(errors: ['name' => 'Too short']),
    );
    $children = array_values(ComponentTree::of($component)['contents']);

    expect(array_column($children, 'type'))->toBe([
        ComponentEnum::LABEL->value,
        ComponentEnum::TEXT_INPUT->value,
        ComponentEnum::PARAGRAPH->value,
    ]);
});

test('the sole input group renders only the input inside its wrapper', function (): void {
    $input = new DefaultInput('name', 'Name');
    $input->setRecipe(new InputComponentRecipe(inputGroup: new SoleInputGroup));

    $component = ActionFactory::component(CrudAssistant::make([$input]), 'name');
    $children = array_values(ComponentTree::of($component)['contents']);

    expect($component->getName())->toBe(ComponentEnum::DIV->value)
        ->and(array_column($children, 'type'))->toBe([ComponentEnum::TEXT_INPUT->value]);
});

test('the no wrap sole input group renders only the input inside a collection', function (): void {
    $input = new DefaultInput('name', 'Name');
    $input->setRecipe(new InputComponentRecipe(inputGroup: new NoWrapSoleInputGroup));

    $component = ActionFactory::component(CrudAssistant::make([$input]), 'name');
    $children = array_values(ComponentTree::of($component)['contents']);

    expect($component->getName())->toBe(ComponentEnum::COLLECTION->value)
        ->and(array_column($children, 'type'))->toBe([ComponentEnum::TEXT_INPUT->value]);
});

test('the no wrap input group renders label, input and error inside a collection', function (): void {
    $input = new DefaultInput('name', 'Name');
    $input->setRecipe(new InputComponentRecipe(inputGroup: new NoWrapInputGroup));

    $component = ActionFactory::component(
        CrudAssistant::make([$input]),
        'name',
        ActionFactory::make(errors: ['name' => 'Too short']),
    );
    $children = array_values(ComponentTree::of($component)['contents']);

    expect($component->getName())->toBe(ComponentEnum::COLLECTION->value)
        ->and(array_column($children, 'type'))->toBe([
            ComponentEnum::LABEL->value,
            ComponentEnum::TEXT_INPUT->value,
            ComponentEnum::PARAGRAPH->value,
        ]);
});

test('the label container group wraps the input inside the label', function (): void {
    $input = new DefaultInput('name', 'Name');
    $input->setRecipe(new InputComponentRecipe(inputGroup: new LabelContainerGroup));

    $component = ActionFactory::component(
        CrudAssistant::make([$input]),
        'name',
        ActionFactory::make(errors: ['name' => 'Too short']),
    );
    $children = array_values(ComponentTree::of($component)['contents']);
    $label = $children[0];

    expect($component->getName())->toBe(ComponentEnum::DIV->value)
        ->and(array_column($children, 'type'))->toBe([
            ComponentEnum::LABEL->value,
            ComponentEnum::PARAGRAPH->value,
        ])
        ->and($label['contents']['input']['type'] ?? null)->toBe(ComponentEnum::TEXT_INPUT->value);
});

test('the label container group requires a label', function (): void {
    $input = new DefaultInput('name', 'Name');
    $input->setRecipe(new InputComponentRecipe(
        inputGroup: new LabelContainerGroup,
        disableBag: (new DefaultDisableBag)->setDisableLabel(),
    ));

    expect(static fn () => ActionFactory::component(CrudAssistant::make([$input]), 'name'))
        ->toThrow(Exception::class, 'The label is mandatory to use this group');
});

test('a wrapping group falls back to a collection when the wrapper is disabled', function (): void {
    $input = new DefaultInput('name', 'Name');
    $input->setRecipe(new InputComponentRecipe(
        inputGroup: new DefaultInputGroup,
        disableBag: (new DefaultDisableBag)->setDisableWrapper(),
    ));

    $component = ActionFactory::component(
        CrudAssistant::make([$input]),
        'name',
        ActionFactory::make(errors: ['name' => 'Too short']),
    );
    $children = array_values(ComponentTree::of($component)['contents']);

    expect($component->getName())->toBe(ComponentEnum::COLLECTION->value)
        ->and(array_column($children, 'type'))->toBe([
            ComponentEnum::LABEL->value,
            ComponentEnum::TEXT_INPUT->value,
            ComponentEnum::PARAGRAPH->value,
        ]);
});

test('it omits the error component when there is no error', function (): void {
    $input = new DefaultInput('name', 'Name');
    $input->setRecipe(new InputComponentRecipe(inputGroup: new DefaultInputGroup));

    $component = ActionFactory::component(CrudAssistant::make([$input]), 'name');
    $children = array_values(ComponentTree::of($component)['contents']);

    expect(array_column($children, 'type'))->toBe([
        ComponentEnum::LABEL->value,
        ComponentEnum::TEXT_INPUT->value,
    ]);
});
