<?php

declare(strict_types=1);

namespace Tests\Feature;

use Exception;
use Juaniquillo\BackendComponents\Contracts\BackendComponent;
use Juaniquillo\BackendComponents\Enums\ComponentEnum;
use Juaniquillo\CrudAssistant\Actions\FilterAction;
use Juaniquillo\CrudAssistant\Contracts\InputInterface;
use Juaniquillo\CrudAssistant\CrudAssistant;
use Juaniquillo\CrudAssistant\InputCollection;
use Juaniquillo\CrudAssistant\Inputs\DefaultInput;
use Juaniquillo\InputComponentAction\Bags\DefaultAttributeBag;
use Juaniquillo\InputComponentAction\Bags\DefaultComponentBag;
use Juaniquillo\InputComponentAction\Bags\DefaultHookBag;
use Juaniquillo\InputComponentAction\Bags\DefaultThemeBag;
use Juaniquillo\InputComponentAction\Contracts\ErrorManager;
use Juaniquillo\InputComponentAction\Contracts\ValueManager;
use Juaniquillo\InputComponentAction\Recipes\InputComponentRecipe;
use Juaniquillo\InputComponentAction\Utilities\Support;
use Tests\Support\ActionFactory;
use Tests\Support\ComponentTree;

test('it resolves nested collections into a wrapper component', function (): void {
    $nested = new InputCollection('group');
    $nested->setInputs([
        new DefaultInput('a', 'A'),
        new DefaultInput('b', 'B'),
    ]);
    $nested->setRecipe(new InputComponentRecipe(
        attributeBag: (new DefaultAttributeBag)->setWrapperAttributes(['class' => 'group']),
        themeBag: (new DefaultThemeBag)->setWrapperTheme(['margin' => 'top-sm']),
    ));

    $root = CrudAssistant::make([
        new DefaultInput('top', 'Top'),
        $nested,
    ]);

    $output = ActionFactory::output($root);
    $group = $output->inputs->get('group');
    $children = array_values(ComponentTree::contentsOf($group));

    expect(array_keys($output->inputs->all()))->toBe(['top', 'group'])
        ->and($group)->toBeInstanceOf(BackendComponent::class)
        ->and($group->getAttributes())->toBe(['class' => 'group'])
        ->and($group->getThemes())->toBe(['margin' => 'top-sm'])
        ->and(array_column($children, 'type'))->toBe([
            ComponentEnum::DIV->value,
            ComponentEnum::DIV->value,
        ]);
});

test('it applies a custom wrapper type to a nested collection', function (): void {
    $nested = new InputCollection('group');
    $nested->setInputs([new DefaultInput('a', 'A')]);
    $nested->setRecipe(new InputComponentRecipe(
        componentBag: (new DefaultComponentBag)->setWrapperType(ComponentEnum::FIELDSET),
    ));

    $output = ActionFactory::output(CrudAssistant::make([$nested]));
    $group = $output->inputs->get('group');

    expect($group->getName())->toBe(ComponentEnum::FIELDSET->value);
});

test('it applies wrapper hooks to a nested collection', function (): void {
    $nested = new InputCollection('group');
    $nested->setInputs([new DefaultInput('a', 'A')]);
    $nested->setRecipe(new InputComponentRecipe(
        hookBag: (new DefaultHookBag)->setWrapperHook(
            static fn (BackendComponent $component): BackendComponent => $component->setAttribute('data-group-hook', 'yes'),
        ),
    ));

    $output = ActionFactory::output(CrudAssistant::make([$nested]));
    $group = $output->inputs->get('group');

    expect($group->getAttribute('data-group-hook'))->toBe('yes');
});

test('it passes values and errors to nested collection wrapper hooks', function (): void {
    $nested = new InputCollection('group');
    $nested->setInputs([new DefaultInput('a', 'A')]);
    $nested->setRecipe(new InputComponentRecipe(
        hookBag: (new DefaultHookBag)->setWrapperHook(
            static function (
                BackendComponent $component,
                InputInterface $input,
                mixed $type,
                ?ValueManager $values,
                ?ErrorManager $errors,
            ): BackendComponent {
                $error = $errors?->resolve($input, Support::getRecipe($input));

                return $component
                    ->setAttribute('data-value', (string) $values?->getValues()['top'])
                    ->setAttribute('data-error', $error ?? '');
            },
        ),
    ));

    $output = ActionFactory::output(
        CrudAssistant::make([$nested]),
        ActionFactory::make(['top' => 'value'], ['group' => 'Group error']),
    );
    $group = $output->inputs->get('group');

    expect($group->getAttribute('data-value'))->toBe('value')
        ->and($group->getAttribute('data-error'))->toBe('Group error');
});

test('it skips ignored inputs at the top level', function (): void {
    $ignored = new DefaultInput('ignored', 'Ignored');
    $ignored->setRecipe((new InputComponentRecipe)->ignore());

    $output = ActionFactory::output(CrudAssistant::make([
        new DefaultInput('kept', 'Kept'),
        $ignored,
    ]));

    expect(array_keys($output->inputs->all()))->toBe(['kept']);
});

test('it skips inputs scoped to another action', function (): void {
    $filtered = new DefaultInput('filtered', 'Filtered');
    $filtered->onlyFor([FilterAction::class]);

    $output = ActionFactory::output(CrudAssistant::make([
        new DefaultInput('kept', 'Kept'),
        $filtered,
    ]));

    expect(array_keys($output->inputs->all()))->toBe(['kept']);
});

test('it skips ignored inputs inside nested collections', function (): void {
    $ignored = new DefaultInput('ignored', 'Ignored');
    $ignored->setRecipe((new InputComponentRecipe)->ignore());

    $nested = new InputCollection('group');
    $nested->setInputs([
        new DefaultInput('kept', 'Kept'),
        $ignored,
    ]);

    $output = ActionFactory::output(CrudAssistant::make([$nested]));
    $group = $output->inputs->get('group');

    expect(ComponentTree::rawContents($group))->toHaveCount(1);
});

test('it skips inputs scoped to another action inside nested collections', function (): void {
    $filtered = new DefaultInput('filtered', 'Filtered');
    $filtered->onlyFor([FilterAction::class]);

    $nested = new InputCollection('group');
    $nested->setInputs([
        new DefaultInput('kept', 'Kept'),
        $filtered,
    ]);

    $output = ActionFactory::output(CrudAssistant::make([$nested]));
    $group = $output->inputs->get('group');

    expect(ComponentTree::rawContents($group))->toHaveCount(1);
});

test('it requires nested collections to have a name', function (): void {
    $nested = new InputCollection;
    $nested->setInputs([new DefaultInput('a', 'A')]);

    expect(static fn () => ActionFactory::output(CrudAssistant::make([$nested])))
        ->toThrow(Exception::class, 'must have a name');
});

test('it can disable recursion and resolve nested inputs individually', function (): void {
    $nested = new InputCollection('group');
    $nested->setInputs([
        new DefaultInput('a', 'A'),
        new DefaultInput('b', 'B'),
    ]);

    $root = CrudAssistant::make([$nested]);
    $action = ActionFactory::make()->setControlsRecursion(false);

    $output = ActionFactory::output($root, $action);

    expect(array_keys($output->inputs->all()))->toBe(['a', 'b']);
});
