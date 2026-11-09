<?php

declare(strict_types=1);

use Juaniquillo\BackendComponents\Enums\ComponentEnum;
use Juaniquillo\CrudAssistant\CrudAssistant;
use Juaniquillo\CrudAssistant\Inputs\DefaultInput;
use Juaniquillo\CrudAssistant\Inputs\RadioGroupInput;
use Juaniquillo\InputComponentAction\Bags\DefaultAttributeBag;
use Juaniquillo\InputComponentAction\Bags\DefaultComponentBag;
use Juaniquillo\InputComponentAction\Recipes\CheckboxComponentRecipe;
use Juaniquillo\InputComponentAction\Recipes\InputComponentRecipe;
use Juaniquillo\InputComponentAction\Recipes\RadioComponentRecipe;
use Tests\Support\ActionFactory;
use Tests\Support\ComponentTree;

test('the radio recipe inherits the group name and value', function (): void {
    $group = new RadioGroupInput('choice', 'Choice');
    $group->setRecipe(new InputComponentRecipe(
        componentBag: (new DefaultComponentBag)->setInputType(ComponentEnum::DIV),
    ));

    $group->setSubElements(CrudAssistant::make([
        (new DefaultInput('a', 'A'))->setRecipe(new RadioComponentRecipe),
        (new DefaultInput('b', 'B'))->setRecipe(new RadioComponentRecipe),
    ]));

    $component = ActionFactory::component(
        CrudAssistant::make([$group]),
        'choice',
        ActionFactory::make(['choice' => 'a']),
    );
    $radios = ComponentTree::findAll($component, ComponentEnum::RADIO_INPUT->value);

    expect($radios)->toHaveCount(2)
        ->and($radios[0]->getAttribute('name'))->toBe('choice')
        ->and($radios[0]->getAttribute('id'))->toBe('a')
        ->and($radios[0]->getAttribute('value'))->toBe('a')
        ->and($radios[0]->getAttribute('checked'))->toBe('checked')
        ->and($radios[0]->getContent(0))->toBe('A')
        ->and($radios[1]->getAttribute('name'))->toBe('choice')
        ->and($radios[1]->getAttribute('value'))->toBe('b')
        ->and($radios[1]->getAttribute('checked'))->toBeNull();
});

test('the checkbox recipe checks options from an array parent value', function (): void {
    $group = new DefaultInput('features', 'Features');
    $group->setRecipe(new InputComponentRecipe(
        componentBag: (new DefaultComponentBag)->setInputType(ComponentEnum::DIV),
    ));

    $group->setSubElements(CrudAssistant::make([
        (new DefaultInput('a', 'A'))->setRecipe(new CheckboxComponentRecipe),
        (new DefaultInput('b', 'B'))->setRecipe(new CheckboxComponentRecipe),
        (new DefaultInput('c', 'C'))->setRecipe(new CheckboxComponentRecipe),
    ]));

    $component = ActionFactory::component(
        CrudAssistant::make([$group]),
        'features',
        ActionFactory::make(['features' => ['a', 'c']]),
    );
    $checkboxes = ComponentTree::findAll($component, ComponentEnum::CHECKBOX_INPUT->value);

    expect($checkboxes)->toHaveCount(3)
        ->and($checkboxes[0]->getAttribute('name'))->toBe('features')
        ->and($checkboxes[0]->getAttribute('value'))->toBe('a')
        ->and($checkboxes[0]->getAttribute('checked'))->toBe('checked')
        ->and($checkboxes[1]->getAttribute('checked'))->toBeNull()
        ->and($checkboxes[2]->getAttribute('value'))->toBe('c')
        ->and($checkboxes[2]->getAttribute('checked'))->toBe('checked');
});

test('the checkbox recipe works as a standalone input', function (): void {
    $input = new DefaultInput('terms', 'I accept');
    $input->setRecipe(new CheckboxComponentRecipe);

    $component = ActionFactory::component(
        CrudAssistant::make([$input]),
        'terms',
        ActionFactory::make(['terms' => true]),
    );
    $checkbox = ComponentTree::find($component, ComponentEnum::CHECKBOX_INPUT->value);

    expect($checkbox->getAttribute('name'))->toBe('terms')
        ->and($checkbox->getAttribute('checked'))->toBe('checked');
});

test('an explicit name attribute wins over the inherited parent name', function (): void {
    $group = new RadioGroupInput('choice', 'Choice');
    $group->setRecipe(new InputComponentRecipe(
        componentBag: (new DefaultComponentBag)->setInputType(ComponentEnum::DIV),
    ));

    $group->setSubElements(CrudAssistant::make([
        (new DefaultInput('a', 'A'))->setRecipe(
            (new RadioComponentRecipe)->setAttributeBag(
                (new DefaultAttributeBag)->setInputAttributes(['name' => 'custom']),
            ),
        ),
    ]));

    $component = ActionFactory::component(CrudAssistant::make([$group]), 'choice');
    $radio = ComponentTree::find($component, ComponentEnum::RADIO_INPUT->value);

    expect($radio->getAttribute('name'))->toBe('custom');
});
