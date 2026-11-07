<?php

declare(strict_types=1);

namespace Tests\Feature;

use Juaniquillo\BackendComponents\Enums\ComponentEnum;
use Juaniquillo\BackendComponents\Themes\DefaultThemeManager;
use Juaniquillo\CrudAssistant\CrudAssistant;
use Juaniquillo\CrudAssistant\Inputs\DefaultInput;
use Juaniquillo\CrudAssistant\Inputs\OptionInput;
use Juaniquillo\CrudAssistant\Inputs\SelectInput;
use Juaniquillo\InputComponentAction\Bags\DefaultComponentBag;
use Juaniquillo\InputComponentAction\Recipes\InputComponentRecipe;
use Juaniquillo\InputComponentAction\Recipes\SelectOptionComponentRecipe;
use Tests\Support\ActionFactory;

test('it renders a simple input and error as html', function (): void {
    $input = new DefaultInput('name', 'Name');
    $input->setRecipe(new InputComponentRecipe);

    $component = ActionFactory::component(
        CrudAssistant::make([$input]),
        'name',
        ActionFactory::make(['name' => 'Alice'], ['name' => 'Too short'])
            ->setThemeManager(DefaultThemeManager::class),
    );

    $this->blade('{{ $component }}', ['component' => $component])
        ->assertSee('Name')
        ->assertSee('name="name"', false)
        ->assertSee('id="name"', false)
        ->assertSee('value="Alice"', false)
        ->assertSee('Too short');
});

test('it renders a select with options as html', function (): void {
    $select = new SelectInput('choice', 'Choice');
    $select->setRecipe(new InputComponentRecipe(
        componentBag: (new DefaultComponentBag)
            ->setInputType(ComponentEnum::SELECT),
    ));
    $select->setSubElements(CrudAssistant::make([
        (new OptionInput('a', 'A'))
            ->setRecipe(new SelectOptionComponentRecipe(inputValue: 'a')),
        (new OptionInput('b', 'B'))
            ->setRecipe(new SelectOptionComponentRecipe(inputValue: 'b')),
    ]));

    $component = ActionFactory::component(
        CrudAssistant::make([$select]),
        'choice',
        ActionFactory::make(['choice' => 'a'])->setThemeManager(DefaultThemeManager::class),
    );

    $this->blade('{{ $component }}', ['component' => $component])
        ->assertSee('<select', false)
        ->assertSee('<option', false)
        ->assertSee('value="a"', false)
        ->assertSee('selected="selected"', false)
        ->assertSee('A')
        ->assertSee('B');
});
