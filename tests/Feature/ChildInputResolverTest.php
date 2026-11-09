<?php

declare(strict_types=1);

namespace Tests\Feature;

use Juaniquillo\BackendComponents\Contracts\BackendComponent;
use Juaniquillo\BackendComponents\Enums\ComponentEnum;
use Juaniquillo\CrudAssistant\Actions\FilterAction;
use Juaniquillo\CrudAssistant\CrudAssistant;
use Juaniquillo\CrudAssistant\Inputs\OptionInput;
use Juaniquillo\CrudAssistant\Inputs\SelectInput;
use Juaniquillo\InputComponentAction\Bags\DefaultComponentBag;
use Juaniquillo\InputComponentAction\InputComponentAction;
use Juaniquillo\InputComponentAction\Recipes\InputComponentRecipe;
use Juaniquillo\InputComponentAction\Recipes\SelectOptionComponentRecipe;
use Tests\Support\ActionFactory;
use Tests\Support\ComponentTree;

function childResolverSelect(array $options): SelectInput
{
    $select = new SelectInput('choice', 'Choice');
    $select->setRecipe(new InputComponentRecipe(
        componentBag: (new DefaultComponentBag)->setInputType(ComponentEnum::SELECT),
    ));
    $select->setSubElements(CrudAssistant::make($options));

    return $select;
}

function childResolverOptions(BackendComponent $component): array
{
    return ComponentTree::findAll($component, ComponentEnum::OPTION->value);
}

test('it resolves sub elements of an input', function (): void {
    $select = childResolverSelect([
        (new OptionInput('a', 'A'))->setRecipe(new SelectOptionComponentRecipe(inputValue: 'a')),
        (new OptionInput('b', 'B'))->setRecipe(new SelectOptionComponentRecipe(inputValue: 'b')),
    ]);

    $options = childResolverOptions(ActionFactory::component(CrudAssistant::make([$select]), 'choice'));

    expect($options)->toHaveCount(2)
        ->and($options[0]->getAttribute('value'))->toBe('a')
        ->and($options[1]->getAttribute('value'))->toBe('b');
});

test('it skips ignored sub elements', function (): void {
    $ignored = (new OptionInput('a', 'A'))->setRecipe(
        (new SelectOptionComponentRecipe(inputValue: 'a'))->ignore(),
    );

    $select = childResolverSelect([
        $ignored,
        (new OptionInput('b', 'B'))->setRecipe(new SelectOptionComponentRecipe(inputValue: 'b')),
    ]);

    $options = childResolverOptions(ActionFactory::component(CrudAssistant::make([$select]), 'choice'));

    expect($options)->toHaveCount(1)
        ->and($options[0]->getAttribute('value'))->toBe('b');
});

test('it skips sub elements scoped to another action', function (): void {
    $filtered = (new OptionInput('a', 'A'))->onlyFor([FilterAction::class]);
    $filtered->setRecipe(new SelectOptionComponentRecipe(inputValue: 'a'));

    $select = childResolverSelect([
        $filtered,
        (new OptionInput('b', 'B'))->setRecipe(new SelectOptionComponentRecipe(inputValue: 'b')),
    ]);

    $options = childResolverOptions(ActionFactory::component(CrudAssistant::make([$select]), 'choice'));

    expect($options)->toHaveCount(1)
        ->and($options[0]->getAttribute('value'))->toBe('b');
});

test('it renders a sub element scoped to this action', function (): void {
    $included = (new OptionInput('a', 'A'))->onlyFor([InputComponentAction::class]);
    $included->setRecipe(new SelectOptionComponentRecipe(inputValue: 'a'));

    $select = childResolverSelect([$included]);

    $options = childResolverOptions(ActionFactory::component(CrudAssistant::make([$select]), 'choice'));

    expect($options)->toHaveCount(1)
        ->and($options[0]->getAttribute('value'))->toBe('a');
});

test('it does not render contents when every sub element is skipped', function (): void {
    $ignored = (new OptionInput('a', 'A'))->setRecipe(
        (new SelectOptionComponentRecipe(inputValue: 'a'))->ignore(),
    );

    $select = childResolverSelect([$ignored]);

    $component = ActionFactory::component(CrudAssistant::make([$select]), 'choice');
    $selectComponent = ComponentTree::find($component, ComponentEnum::SELECT->value);

    expect($selectComponent)->not->toBeNull()
        ->and(ComponentTree::of($selectComponent)['contents'])->toBe([]);
});

test('it does not render contents when the sub element collection is empty', function (): void {
    $select = childResolverSelect([]);

    $component = ActionFactory::component(CrudAssistant::make([$select]), 'choice');
    $selectComponent = ComponentTree::find($component, ComponentEnum::SELECT->value);

    expect($selectComponent)->not->toBeNull()
        ->and(ComponentTree::of($selectComponent)['contents'])->toBe([]);
});

test('it resolves an unnamed sub element', function (): void {
    $option = (new OptionInput(null, 'A'))->setRecipe(
        new SelectOptionComponentRecipe(inputValue: 'a'),
    );

    $select = childResolverSelect([$option]);

    $options = childResolverOptions(ActionFactory::component(CrudAssistant::make([$select]), 'choice'));

    expect($options)->toHaveCount(1)
        ->and($options[0]->getAttribute('name'))->toBeNull()
        ->and($options[0]->getContent(0))->toBe('A');
});

test('it keeps the parent linkage for sub element values', function (): void {
    $select = childResolverSelect([
        (new OptionInput('a', 'A'))->setRecipe(new SelectOptionComponentRecipe(inputValue: 'a')),
        (new OptionInput('b', 'B'))->setRecipe(new SelectOptionComponentRecipe(inputValue: 'b')),
    ]);

    $component = ActionFactory::component(
        CrudAssistant::make([$select]),
        'choice',
        ActionFactory::make(['choice' => 'b']),
    );
    $options = childResolverOptions($component);

    expect($options[0]->getAttribute('selected'))->toBeNull()
        ->and($options[1]->getAttribute('selected'))->toBe('selected');
});

test('it applies per sub element recipe overrides', function (): void {
    $select = childResolverSelect([
        (new OptionInput('a', 'A'))->setRecipe(new SelectOptionComponentRecipe(
            inputValue: 'a',
            componentBag: (new DefaultComponentBag)->setInputType(ComponentEnum::OPTGROUP),
        )),
        (new OptionInput('b', 'B'))->setRecipe(new SelectOptionComponentRecipe(inputValue: 'b')),
    ]);

    $component = ActionFactory::component(CrudAssistant::make([$select]), 'choice');
    $groups = ComponentTree::findAll($component, ComponentEnum::OPTGROUP->value);

    expect($groups)->toHaveCount(1)
        ->and(childResolverOptions($component))->toHaveCount(1);
});
