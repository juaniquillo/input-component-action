<?php

declare(strict_types=1);

namespace Tests\Feature;

use BackedEnum;
use Juaniquillo\BackendComponents\Contracts\BackendComponent;
use Juaniquillo\BackendComponents\Contracts\ThemeManager;
use Juaniquillo\BackendComponents\Enums\ComponentEnum;
use Juaniquillo\BackendComponents\MainBackendComponent;
use Juaniquillo\BackendComponents\Themes\DefaultThemeManager;
use Juaniquillo\BackendComponents\Themes\LocalThemeManager;
use Juaniquillo\CrudAssistant\Contracts\InputInterface;
use Juaniquillo\CrudAssistant\CrudAssistant;
use Juaniquillo\CrudAssistant\Inputs\DefaultInput;
use Juaniquillo\InputComponentAction\Bags\DefaultAttributeBag;
use Juaniquillo\InputComponentAction\Bags\DefaultComponentBag;
use Juaniquillo\InputComponentAction\Bags\DefaultDisableBag;
use Juaniquillo\InputComponentAction\Bags\DefaultHookBag;
use Juaniquillo\InputComponentAction\Bags\DefaultThemeBag;
use Juaniquillo\InputComponentAction\Contracts\ErrorManager;
use Juaniquillo\InputComponentAction\Contracts\ValueManager;
use Juaniquillo\InputComponentAction\Groups\LabelHelpTextInputErrorGroup;
use Juaniquillo\InputComponentAction\Recipes\InputComponentRecipe;
use Juaniquillo\InputComponentAction\Utilities\Support;
use Tests\Support\ActionFactory;
use Tests\Support\ComponentTree;

test('it builds the default input group structure', function (): void {
    $collection = CrudAssistant::make([new DefaultInput('name', 'Name')]);
    $component = ActionFactory::component(
        $collection,
        'name',
        ActionFactory::make(['name' => 'Alice'], ['name' => 'Too short']),
    );

    $tree = ComponentTree::of($component);
    $children = array_values($tree['contents']);

    expect($tree['type'])->toBe(ComponentEnum::DIV->value)
        ->and($children)->toHaveCount(3)
        ->and($children[0]['type'])->toBe(ComponentEnum::LABEL->value)
        ->and($children[0]['attributes'])->toBe(['for' => 'name'])
        ->and($children[0]['contents'])->toBe(['Name'])
        ->and($children[1]['type'])->toBe(ComponentEnum::TEXT_INPUT->value)
        ->and($children[1]['attributes'])->toBe([
            'name' => 'name',
            'id' => 'name',
            'value' => 'Alice',
        ])
        ->and($children[1]['contents'])->toBe([])
        ->and($children[2]['type'])->toBe(ComponentEnum::PARAGRAPH->value)
        ->and($children[2]['contents'])->toBe(['Too short']);
});

test('it resolves values from the values array, recipe and model in that order', function (): void {
    $input = new DefaultInput('name', 'Name');
    $input->setRecipe(new InputComponentRecipe(inputValue: 'recipe-value'));

    $action = ActionFactory::make(['name' => 'array-value'])
        ->setModel((object) ['name' => 'model-value']);

    $component = ActionFactory::component(CrudAssistant::make([$input]), 'name', $action);
    $inputComponent = ComponentTree::find($component, ComponentEnum::TEXT_INPUT->value);

    expect($inputComponent->getAttribute('value'))->toBe('array-value');

    $component = ActionFactory::component(
        CrudAssistant::make([$input]),
        'name',
        ActionFactory::make()->setModel((object) ['name' => 'model-value']),
    );
    $inputComponent = ComponentTree::find($component, ComponentEnum::TEXT_INPUT->value);

    expect($inputComponent->getAttribute('value'))->toBe('recipe-value');

    $input->setRecipe(new InputComponentRecipe);

    $component = ActionFactory::component(
        CrudAssistant::make([$input]),
        'name',
        ActionFactory::make()->setModel((object) ['name' => 'model-value']),
    );
    $inputComponent = ComponentTree::find($component, ComponentEnum::TEXT_INPUT->value);

    expect($inputComponent->getAttribute('value'))->toBe('model-value');
});

test('it uses the recipe value as input content when enabled', function (): void {
    $input = new DefaultInput('name', 'Name');
    $input->setRecipe(new InputComponentRecipe(
        inputValue: 'content-value',
        valueAsInputContent: true,
    ));

    $component = ActionFactory::component(CrudAssistant::make([$input]), 'name');
    $inputComponent = ComponentTree::find($component, ComponentEnum::TEXT_INPUT->value);

    expect($inputComponent)->not->toBeNull()
        ->and($inputComponent->getAttribute('value'))->toBeNull()
        ->and(ComponentTree::of($inputComponent)['contents'])->toBe(['content-value']);
});

test('it uses the label as input content when enabled', function (): void {
    $input = new DefaultInput('name', 'Name');
    $input->setRecipe(new InputComponentRecipe(labelAsInputContent: true));

    $component = ActionFactory::component(CrudAssistant::make([$input]), 'name');
    $inputComponent = ComponentTree::find($component, ComponentEnum::TEXT_INPUT->value);

    expect($inputComponent->getAttribute('value'))->toBe('')
        ->and(ComponentTree::of($inputComponent)['contents'])->toBe(['Name']);
});

test('it can render an empty label', function (): void {
    $input = new DefaultInput('name', 'Name');
    $input->setRecipe(new InputComponentRecipe(emptyLabel: true));

    $component = ActionFactory::component(CrudAssistant::make([$input]), 'name');
    $label = ComponentTree::find($component, ComponentEnum::LABEL->value);

    expect($label)->not->toBeNull()
        ->and(ComponentTree::of($label)['contents'])->toBe([]);
});

test('it handles inputs without a label', function (): void {
    $input = new class('name') extends DefaultInput
    {
        public function getLabel(): ?string
        {
            return null;
        }
    };
    $input->setRecipe(new InputComponentRecipe(labelAsInputContent: true));

    $component = ActionFactory::component(CrudAssistant::make([$input]), 'name');
    $label = ComponentTree::find($component, ComponentEnum::LABEL->value);
    $inputComponent = ComponentTree::find($component, ComponentEnum::TEXT_INPUT->value);

    expect($label)->not->toBeNull()
        ->and(ComponentTree::of($label)['contents'])->toBe([])
        ->and(ComponentTree::of($inputComponent)['contents'])->toBe([]);
});

test('it applies recipe attributes over the defaults', function (): void {
    $input = new DefaultInput('name', 'Name');
    $input->setRecipe(new InputComponentRecipe(
        attributeBag: (new DefaultAttributeBag)
            ->setWrapperAttributes(['class' => 'wrapper'])
            ->setLabelAttributes(['class' => 'label'])
            ->setInputAttributes([
                'name' => 'custom-name',
                'id' => 'custom-id',
                'value' => 'custom-value',
                'data-input' => 'yes',
            ])
            ->setHelpTextAttributes(['class' => 'help']),
        helpText: 'Some help',
        inputGroup: new LabelHelpTextInputErrorGroup,
    ));

    $component = ActionFactory::component(CrudAssistant::make([$input]), 'name');
    $children = array_values(ComponentTree::of($component)['contents']);

    expect(ComponentTree::of($component)['attributes'])->toBe(['class' => 'wrapper'])
        ->and($children)->toHaveCount(3)
        ->and($children[0]['attributes'])->toBe(['for' => 'name', 'class' => 'label'])
        ->and($children[1]['attributes'])->toBe(['class' => 'help'])
        ->and($children[2]['attributes'])->toBe([
            'name' => 'custom-name',
            'id' => 'custom-id',
            'value' => 'custom-value',
            'data-input' => 'yes',
        ]);
});

test('it applies themes per slot', function (): void {
    $input = new DefaultInput('name', 'Name');
    $input->setRecipe(new InputComponentRecipe(
        themeBag: (new DefaultThemeBag)
            ->setWrapperTheme(['margin' => 'top-sm'])
            ->setLabelTheme(['color' => 'gray'])
            ->setInputTheme(['border' => 'sm'])
            ->setErrorTheme(['color' => 'red'])
            ->setHelpTextTheme(['font' => 'sm']),
        helpText: 'Some help',
        inputGroup: new LabelHelpTextInputErrorGroup,
    ));

    $component = ActionFactory::component(
        CrudAssistant::make([$input]),
        'name',
        ActionFactory::make(errors: ['name' => 'Too short']),
    );
    $children = array_values(ComponentTree::of($component)['contents']);

    expect($component->getThemes())->toBe(['margin' => 'top-sm'])
        ->and($children[0]['themes'])->toBe(['color' => 'gray'])
        ->and($children[1]['themes'])->toBe(['font' => 'sm'])
        ->and($children[2]['themes'])->toBe(['border' => 'sm'])
        ->and($children[3]['themes'])->toBe(['color' => 'red']);
});

test('it falls back to the action default themes and lets the recipe override them', function (): void {
    $input = new DefaultInput('name', 'Name');
    $action = ActionFactory::make()->setDefaultThemeBag(
        (new DefaultThemeBag)
            ->setInputTheme(['border' => 'sm'])
            ->setLabelTheme(['color' => 'gray']),
    );

    $component = ActionFactory::component(CrudAssistant::make([$input]), 'name', $action);
    $label = ComponentTree::find($component, ComponentEnum::LABEL->value);
    $inputComponent = ComponentTree::find($component, ComponentEnum::TEXT_INPUT->value);

    expect($inputComponent->getThemes())->toBe(['border' => 'sm'])
        ->and($label->getThemes())->toBe(['color' => 'gray']);

    $input->setRecipe(new InputComponentRecipe(
        themeBag: (new DefaultThemeBag)->setInputTheme(['border' => 'lg']),
    ));

    $component = ActionFactory::component(CrudAssistant::make([$input]), 'name', $action);
    $inputComponent = ComponentTree::find($component, ComponentEnum::TEXT_INPUT->value);

    expect($inputComponent->getThemes())->toBe(['border' => 'lg']);
});

test('it applies hooks to every slot', function (): void {
    $input = new DefaultInput('name', 'Name');
    $input->setRecipe(new InputComponentRecipe(
        helpText: 'Some help',
        inputGroup: new LabelHelpTextInputErrorGroup,
        hookBag: (new DefaultHookBag)
            ->setWrapperHook(static function (BackendComponent $component): BackendComponent {
                return $component->setAttribute('data-wrapper-hook', 'yes');
            })
            ->setLabelHook(static function (BackendComponent $component): BackendComponent {
                return $component->setAttribute('data-label-hook', 'yes');
            })
            ->setInputHook(static function (BackendComponent $component): BackendComponent {
                return $component->setAttribute('data-input-hook', 'yes');
            })
            ->setErrorHook(static function (BackendComponent $component): BackendComponent {
                return $component->setAttribute('data-error-hook', 'yes');
            })
            ->setHelpTextHook(static function (BackendComponent $component): BackendComponent {
                return $component->setAttribute('data-help-hook', 'yes');
            }),
    ));

    $component = ActionFactory::component(
        CrudAssistant::make([$input]),
        'name',
        ActionFactory::make(errors: ['name' => 'Too short']),
    );

    $children = array_values(ComponentTree::of($component)['contents']);

    expect($component->getAttribute('data-wrapper-hook'))->toBe('yes')
        ->and($children[0]['attributes']['data-label-hook'])->toBe('yes')
        ->and($children[1]['attributes']['data-help-hook'])->toBe('yes')
        ->and($children[2]['attributes']['data-input-hook'])->toBe('yes')
        ->and($children[3]['attributes']['data-error-hook'])->toBe('yes');
});

test('it passes values and errors to component hooks', function (): void {
    $input = new DefaultInput('name', 'Name');
    $input->setRecipe(new InputComponentRecipe(
        hookBag: (new DefaultHookBag)->setInputHook(
            static function (
                BackendComponent $component,
                InputInterface $input,
                string|BackedEnum $type,
                ?ValueManager $values,
                ?ErrorManager $errors,
            ): BackendComponent {
                $error = $errors?->resolve($input, Support::getRecipe($input));

                return $component
                    ->setAttribute('data-value', (string) $values?->getValues()['name'])
                    ->setAttribute('data-error', $error ?? '');
            },
        ),
    ));

    $component = ActionFactory::component(
        CrudAssistant::make([$input]),
        'name',
        ActionFactory::make(['name' => 'Alice'], ['name' => 'Too short']),
    );
    $inputComponent = ComponentTree::find($component, ComponentEnum::TEXT_INPUT->value);

    expect($inputComponent->getAttribute('data-value'))->toBe('Alice')
        ->and($inputComponent->getAttribute('data-error'))->toBe('Too short');
});

test('it uses the default component bag for every slot', function (): void {
    $input = new DefaultInput('name', 'Name');
    $input->setRecipe(new InputComponentRecipe(
        helpText: 'Some help',
        inputGroup: new LabelHelpTextInputErrorGroup,
    ));

    $action = ActionFactory::make(errors: ['name' => 'Too short'])->setDefaultComponentBag(
        (new DefaultComponentBag)
            ->setWrapperType(ComponentEnum::FIELDSET)
            ->setLabelType(ComponentEnum::LEGEND)
            ->setInputType(ComponentEnum::TEXTAREA)
            ->setErrorType(ComponentEnum::PARAGRAPH)
            ->setHelpTextType(ComponentEnum::SMALL),
    );

    $component = ActionFactory::component(CrudAssistant::make([$input]), 'name', $action);
    $children = array_values(ComponentTree::of($component)['contents']);

    expect($component->getName())->toBe(ComponentEnum::FIELDSET->value)
        ->and($children[0]['type'])->toBe(ComponentEnum::LEGEND->value)
        ->and($children[1]['type'])->toBe(ComponentEnum::SMALL->value)
        ->and($children[2]['type'])->toBe(ComponentEnum::TEXTAREA->value)
        ->and($children[3]['type'])->toBe(ComponentEnum::PARAGRAPH->value);
});

test('it lets the recipe component bag override the action default', function (): void {
    $input = new DefaultInput('name', 'Name');
    $input->setRecipe(new InputComponentRecipe(
        componentBag: (new DefaultComponentBag)->setInputType(ComponentEnum::EMAIL_INPUT),
    ));

    $action = ActionFactory::make()->setDefaultComponentBag(
        (new DefaultComponentBag)->setInputType(ComponentEnum::TEXTAREA),
    );

    $component = ActionFactory::component(CrudAssistant::make([$input]), 'name', $action);
    $inputComponent = ComponentTree::find($component, ComponentEnum::EMAIL_INPUT->value);

    expect($inputComponent)->not->toBeNull()
        ->and(ComponentTree::find($component, ComponentEnum::TEXTAREA->value))->toBeNull();
});

test('it uses custom components from the component bag', function (): void {
    $input = new DefaultInput('name', 'Name');
    $action = ActionFactory::make()->setDefaultComponentBag(
        (new DefaultComponentBag)->setInputComponent(
            static fn (string|BackedEnum $type, ThemeManager $manager): BackendComponent => (new MainBackendComponent(ComponentEnum::TEXTAREA, $manager))->setAttribute('data-custom', 'yes'),
        ),
    );

    $component = ActionFactory::component(CrudAssistant::make([$input]), 'name', $action);
    $inputComponent = ComponentTree::find($component, ComponentEnum::TEXTAREA->value);

    expect($inputComponent)->not->toBeNull()
        ->and($inputComponent->getAttribute('data-custom'))->toBe('yes');
});

test('it uses the recipe theme manager over the action default', function (): void {
    $input = new DefaultInput('name', 'Name');
    $input->setRecipe(new InputComponentRecipe(themeManager: new LocalThemeManager));

    $action = ActionFactory::make()->setThemeManager(DefaultThemeManager::class);

    $component = ActionFactory::component(CrudAssistant::make([$input]), 'name', $action);
    $inputComponent = ComponentTree::find($component, ComponentEnum::TEXT_INPUT->value);

    expect($inputComponent->getThemeManager())->toBeInstanceOf(LocalThemeManager::class);
});

test('it resolves closure input attributes before the default name and id', function (): void {
    $input = new DefaultInput('name', 'Name');
    $input->setRecipe(new InputComponentRecipe(
        attributeBag: (new DefaultAttributeBag)->setInputAttributes(
            static fn (InputInterface $input, mixed $type): array => [
                'name' => 'closure-name',
                'id' => 'closure-id',
                'placeholder' => 'Type here',
            ],
        ),
    ));

    $component = ActionFactory::component(CrudAssistant::make([$input]), 'name');
    $inputComponent = ComponentTree::find($component, ComponentEnum::TEXT_INPUT->value);

    expect($inputComponent->getAttributes())->toBe([
        'name' => 'closure-name',
        'id' => 'closure-id',
        'value' => '',
        'placeholder' => 'Type here',
    ]);
});

test('it does not render array values as attributes or content', function (): void {
    $input = new DefaultInput('name', 'Name');
    $input->setRecipe(new InputComponentRecipe);

    $component = ActionFactory::component(
        CrudAssistant::make([$input]),
        'name',
        ActionFactory::make(['name' => ['a', 'b']]),
    );
    $inputComponent = ComponentTree::find($component, ComponentEnum::TEXT_INPUT->value);

    expect($inputComponent->getAttribute('value'))->toBeNull()
        ->and(ComponentTree::of($inputComponent)['contents'])->toBe([]);

    $input->setRecipe(new InputComponentRecipe(valueAsInputContent: true));

    $component = ActionFactory::component(
        CrudAssistant::make([$input]),
        'name',
        ActionFactory::make(['name' => ['a', 'b']]),
    );
    $inputComponent = ComponentTree::find($component, ComponentEnum::TEXT_INPUT->value);

    expect($inputComponent->getAttribute('value'))->toBeNull()
        ->and(ComponentTree::of($inputComponent)['contents'])->toBe([]);
});

test('it applies error attributes', function (): void {
    $input = new DefaultInput('name', 'Name');
    $input->setRecipe(new InputComponentRecipe(
        attributeBag: (new DefaultAttributeBag)->setErrorAttributes(
            static fn (InputInterface $input, mixed $type): array => [
                'class' => 'error',
                'data-error' => $input->getName(),
                'data-type' => $type instanceof BackedEnum ? $type->value : $type,
            ],
        ),
    ));

    $component = ActionFactory::component(
        CrudAssistant::make([$input]),
        'name',
        ActionFactory::make(errors: ['name' => 'Too short']),
    );
    $children = array_values(ComponentTree::of($component)['contents']);

    expect($children[2]['type'])->toBe(ComponentEnum::PARAGRAPH->value)
        ->and($children[2]['attributes'])->toBe([
            'class' => 'error',
            'data-error' => 'name',
            'data-type' => ComponentEnum::TEXT_INPUT->value,
        ]);
});

test('it applies closure attributes to the wrapper, label and help text', function (): void {
    $input = new DefaultInput('name', 'Name');
    $input->setRecipe(new InputComponentRecipe(
        helpText: 'Some help',
        inputGroup: new LabelHelpTextInputErrorGroup,
        attributeBag: (new DefaultAttributeBag)
            ->setWrapperAttributes(static fn (InputInterface $input, mixed $type): array => ['data-wrapper' => $input->getName()])
            ->setLabelAttributes(static fn (InputInterface $input, mixed $type): array => ['data-label' => $input->getName()])
            ->setHelpTextAttributes(static fn (InputInterface $input, mixed $type): array => ['data-help' => $input->getName()]),
    ));

    $component = ActionFactory::component(CrudAssistant::make([$input]), 'name');
    $children = array_values(ComponentTree::of($component)['contents']);

    expect($component->getAttribute('data-wrapper'))->toBe('name')
        ->and($children[0]['attributes']['data-label'])->toBe('name')
        ->and($children[1]['attributes']['data-help'])->toBe('name');
});

test('it resolves recipe errors before action errors', function (): void {
    $input = new DefaultInput('name', 'Name');
    $input->setRecipe(new InputComponentRecipe(inputError: 'Recipe error'));

    $component = ActionFactory::component(
        CrudAssistant::make([$input]),
        'name',
        ActionFactory::make(errors: ['name' => 'Action error']),
    );

    $children = array_values(ComponentTree::of($component)['contents']);

    expect($children[2]['contents'])->toBe(['Recipe error']);

    $input->setRecipe(new InputComponentRecipe);

    $component = ActionFactory::component(
        CrudAssistant::make([$input]),
        'name',
        ActionFactory::make(errors: ['name' => 'Action error']),
    );
    $children = array_values(ComponentTree::of($component)['contents']);

    expect($children[2]['contents'])->toBe(['Action error']);
});

test('it applies every disable flag', function (): void {
    $input = new DefaultInput('name', 'Name');
    $input->setRecipe(new InputComponentRecipe(
        helpText: 'Some help',
        inputGroup: new LabelHelpTextInputErrorGroup,
        disableBag: (new DefaultDisableBag)
            ->setDisableLabel()
            ->setDisableError()
            ->setDisableHelpText()
            ->setDisableInputValue()
            ->setDisableDefaultNameAttribute()
            ->setDisableDefaultIdAttribute(),
    ));

    $component = ActionFactory::component(
        CrudAssistant::make([$input]),
        'name',
        ActionFactory::make(['name' => 'Alice'], ['name' => 'Too short']),
    );
    $children = array_values(ComponentTree::of($component)['contents']);

    expect($children)->toHaveCount(1)
        ->and($children[0]['type'])->toBe(ComponentEnum::TEXT_INPUT->value)
        ->and($children[0]['attributes'])->toBe([]);

    $input->setRecipe(new InputComponentRecipe(
        disableBag: (new DefaultDisableBag)->setDisableWrapper(),
    ));

    $component = ActionFactory::component(CrudAssistant::make([$input]), 'name');

    expect($component->getName())->toBe(ComponentEnum::COLLECTION->value);
});

test('it disables the default for attribute on the label', function (): void {
    $input = new DefaultInput('name', 'Name');
    $input->setRecipe(new InputComponentRecipe(
        disableBag: (new DefaultDisableBag)->setDisableDefaultForAttribute(),
    ));

    $component = ActionFactory::component(CrudAssistant::make([$input]), 'name');
    $label = ComponentTree::find($component, ComponentEnum::LABEL->value);

    expect($label->getAttribute('for'))->toBeNull();
});
