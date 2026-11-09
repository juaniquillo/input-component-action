<?php

declare(strict_types=1);

use Juaniquillo\BackendComponents\Enums\ComponentEnum;
use Juaniquillo\BackendComponents\Themes\DefaultThemeManager;
use Juaniquillo\CrudAssistant\Contracts\ModifierInterface;
use Juaniquillo\CrudAssistant\CrudAssistant;
use Juaniquillo\CrudAssistant\Inputs\DefaultInput;
use Juaniquillo\CrudAssistant\Inputs\OptionInput;
use Juaniquillo\CrudAssistant\Inputs\RadioGroupInput;
use Juaniquillo\CrudAssistant\Inputs\SelectInput;
use Juaniquillo\InputComponentAction\Bags\DefaultAttributeBag;
use Juaniquillo\InputComponentAction\Bags\DefaultComponentBag;
use Juaniquillo\InputComponentAction\Bags\DefaultDisableBag;
use Juaniquillo\InputComponentAction\Bags\DefaultHookBag;
use Juaniquillo\InputComponentAction\Bags\DefaultThemeBag;
use Juaniquillo\InputComponentAction\Groups\SoleInputGroup;
use Juaniquillo\InputComponentAction\InputComponentAction;
use Juaniquillo\InputComponentAction\Managers\DefaultErrorManager;
use Juaniquillo\InputComponentAction\Managers\DefaultValueManager;
use Juaniquillo\InputComponentAction\Recipes\InputComponentRecipe;
use Juaniquillo\InputComponentAction\Recipes\RadioComponentRecipe;
use Juaniquillo\InputComponentAction\Recipes\SelectOptionComponentRecipe;
use Tests\Support\ActionFactory;
use Tests\Support\ComponentTree;

test('it can be initialized with a disable bag', function (): void {
    $disableBag = new DefaultDisableBag;
    $disableBag->setDisableWrapper(true);

    $recipe = new InputComponentRecipe(disableBag: $disableBag);

    expect($recipe->getDisableBag())
        ->toBe($disableBag);

    expect($recipe->getDisableBag()->disableWrapper())
        ->toBeTrue();
});

test('it can set and get a disable bag', function (): void {
    $recipe = new InputComponentRecipe;
    $disableBag = new DefaultDisableBag;

    $recipe->setDisableBag($disableBag);

    expect($recipe->getDisableBag())
        ->toBe($disableBag);
});

test('it can be initialized with every bag and flag', function (): void {
    $inputGroup = new SoleInputGroup;
    $themeManager = new DefaultThemeManager;
    $componentBag = new DefaultComponentBag;
    $attributeBag = new DefaultAttributeBag;
    $themeBag = new DefaultThemeBag;
    $hookBag = new DefaultHookBag;
    $valueBag = new DefaultValueManager;
    $errorBag = new DefaultErrorManager;
    $disableBag = new DefaultDisableBag;

    $recipe = new InputComponentRecipe(
        inputGroup: $inputGroup,
        themeManager: $themeManager,
        componentBag: $componentBag,
        attributeBag: $attributeBag,
        themeBag: $themeBag,
        hookBag: $hookBag,
        valueBag: $valueBag,
        errorBag: $errorBag,
        disableBag: $disableBag,
        inputValue: 'value',
        inputError: 'error',
        label: 'Label',
        useParentValue: true,
        labelAsInputContent: true,
        emptyLabel: true,
        valueAsInputContent: true,
        helpText: 'Help',
        checkable: true,
        selectable: true,
    );

    expect($recipe->getInputGroup())->toBe($inputGroup)
        ->and($recipe->getThemeManager())->toBe($themeManager)
        ->and($recipe->getComponentBag())->toBe($componentBag)
        ->and($recipe->getAttributeBag())->toBe($attributeBag)
        ->and($recipe->getThemeBag())->toBe($themeBag)
        ->and($recipe->getHookBag())->toBe($hookBag)
        ->and($recipe->getValueBag())->toBe($valueBag)
        ->and($recipe->getErrorBag())->toBe($errorBag)
        ->and($recipe->getDisableBag())->toBe($disableBag)
        ->and($recipe->getInputValue())->toBe('value')
        ->and($recipe->getInputError())->toBe('error')
        ->and($recipe->getLabel())->toBe('Label')
        ->and($recipe->useParentValue())->toBeTrue()
        ->and($recipe->labelAsInputContent())->toBeTrue()
        ->and($recipe->isEmptyLabel())->toBeTrue()
        ->and($recipe->valueAsInputContent())->toBeTrue()
        ->and($recipe->getHelpText())->toBe('Help')
        ->and($recipe->isCheckable())->toBeTrue()
        ->and($recipe->isSelectable())->toBeTrue()
        ->and($recipe->getIdentifier())->toBe(InputComponentAction::getIdentifier());
});

test('the select option recipe applies its defaults', function (): void {
    $recipe = new SelectOptionComponentRecipe;

    expect($recipe->getInputGroup())->toBeInstanceOf(SoleInputGroup::class)
        ->and($recipe->getComponentBag())->toBeInstanceOf(DefaultComponentBag::class)
        ->and($recipe->getComponentBag()->getInputType())->toBe(ComponentEnum::OPTION)
        ->and($recipe->getDisableBag())->toBeInstanceOf(DefaultDisableBag::class)
        ->and($recipe->getDisableBag()->disableWrapper())->toBeTrue()
        ->and($recipe->getDisableBag()->disableDefaultNameAttribute())->toBeTrue()
        ->and($recipe->useParentValue())->toBeTrue()
        ->and($recipe->isSelectable())->toBeTrue()
        ->and($recipe->labelAsInputContent())->toBeTrue()
        ->and($recipe->getIdentifier())->toBe(InputComponentAction::getIdentifier());
});

test('the select option recipe accepts overrides', function (): void {
    $inputGroup = new SoleInputGroup;
    $componentBag = (new DefaultComponentBag)->setInputType(ComponentEnum::OPTION);
    $disableBag = (new DefaultDisableBag)->setDisableWrapper();

    $recipe = new SelectOptionComponentRecipe(
        inputGroup: $inputGroup,
        componentBag: $componentBag,
        disableBag: $disableBag,
        inputValue: 'a',
        label: 'A',
        helpText: 'Help',
    );

    expect($recipe->getInputGroup())->toBe($inputGroup)
        ->and($recipe->getComponentBag())->toBe($componentBag)
        ->and($recipe->getDisableBag())->toBe($disableBag)
        ->and($recipe->getInputValue())->toBe('a')
        ->and($recipe->getLabel())->toBe('A')
        ->and($recipe->getHelpText())->toBe('Help');
});

test('it renders select options and marks the matching option as selected', function (): void {
    $select = new SelectInput('choice', 'Choice');
    $select->setRecipe(new InputComponentRecipe(
        componentBag: (new DefaultComponentBag)->setInputType(ComponentEnum::SELECT),
    ));

    $select->setSubElements(CrudAssistant::make([
        (new OptionInput('a', 'A'))->setRecipe(new SelectOptionComponentRecipe(inputValue: 'a')),
        (new OptionInput('b', 'B'))->setRecipe(new SelectOptionComponentRecipe(inputValue: 'b')),
    ]));

    $component = ActionFactory::component(
        CrudAssistant::make([$select]),
        'choice',
        ActionFactory::make(['choice' => 'a']),
    );
    $selectComponent = ComponentTree::find($component, ComponentEnum::SELECT->value);
    $options = ComponentTree::findAll($selectComponent, ComponentEnum::OPTION->value);

    expect($options)->toHaveCount(2)
        ->and($options[0]->getAttribute('value'))->toBe('a')
        ->and($options[0]->getAttribute('selected'))->toBe('selected')
        ->and($options[0]->getAttribute('name'))->toBeNull()
        ->and($options[0]->getContent(0))->toBe('A')
        ->and($options[1]->getAttribute('value'))->toBe('b')
        ->and($options[1]->getAttribute('selected'))->toBeNull()
        ->and($options[1]->getContent(0))->toBe('B');
});

test('it marks every matching option as selected when the parent value is an array', function (): void {
    $select = new SelectInput('choice', 'Choice');
    $select->setRecipe(new InputComponentRecipe(
        componentBag: (new DefaultComponentBag)->setInputType(ComponentEnum::SELECT),
    ));

    $select->setSubElements(CrudAssistant::make([
        (new OptionInput('a', 'A'))->setRecipe(new SelectOptionComponentRecipe(inputValue: 'a')),
        (new OptionInput('b', 'B'))->setRecipe(new SelectOptionComponentRecipe(inputValue: 'b')),
        (new OptionInput('c', 'C'))->setRecipe(new SelectOptionComponentRecipe(inputValue: 'c')),
    ]));

    $component = ActionFactory::component(
        CrudAssistant::make([$select]),
        'choice',
        ActionFactory::make(['choice' => ['a', 'c']]),
    );
    $selectComponent = ComponentTree::find($component, ComponentEnum::SELECT->value);
    $options = ComponentTree::findAll($selectComponent, ComponentEnum::OPTION->value);

    expect($options)->toHaveCount(3)
        ->and($options[0]->getAttribute('selected'))->toBe('selected')
        ->and($options[1]->getAttribute('selected'))->toBeNull()
        ->and($options[2]->getAttribute('selected'))->toBe('selected')
        ->and($selectComponent->getAttribute('value'))->toBeNull();
});

test('it marks the matching radio as checked from the parent value', function (): void {
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
        ->and($radios[0]->getAttribute('value'))->toBe('a')
        ->and($radios[0]->getAttribute('checked'))->toBe('checked')
        ->and($radios[0]->getContent(0))->toBe('A')
        ->and($radios[1]->getAttribute('value'))->toBe('b')
        ->and($radios[1]->getAttribute('checked'))->toBeNull();
});

test('it does not use the parent value when checkable inputs disable it', function (): void {
    $group = new RadioGroupInput('choice', 'Choice');
    $group->setRecipe(new InputComponentRecipe(
        componentBag: (new DefaultComponentBag)->setInputType(ComponentEnum::DIV),
    ));

    $group->setSubElements(CrudAssistant::make([
        (new DefaultInput('a', 'A'))->setRecipe(
            (new RadioComponentRecipe)->setUseParentValue(false),
        ),
    ]));

    $component = ActionFactory::component(
        CrudAssistant::make([$group]),
        'choice',
        ActionFactory::make(['choice' => 'a']),
    );
    $radio = ComponentTree::find($component, ComponentEnum::RADIO_INPUT->value);

    expect($radio->getAttribute('checked'))->toBeNull();
});

test('it applies recipe modifiers to the group component', function (): void {
    $input = new DefaultInput('name', 'Name');
    $input->setRecipe(
        (new InputComponentRecipe)->setModifier(new class implements ModifierInterface
        {
            public function modify(mixed $value, ?object $model = null): mixed
            {
                return $value->setAttribute('data-modified', 'yes');
            }
        }),
    );

    $component = ActionFactory::component(CrudAssistant::make([$input]), 'name');

    expect($component->getAttribute('data-modified'))->toBe('yes');
});
