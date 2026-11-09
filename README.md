# Input Component Action

[![CI](https://github.com/juaniquillo/input-component-action/actions/workflows/ci.yml/badge.svg)](https://github.com/juaniquillo/input-component-action/actions/workflows/ci.yml)

Turn [CrudAssistant](https://github.com/juaniquillo/crud-assistant) inputs into
renderable [Laravel Backend Components](https://github.com/juaniquillo/laravel-backend-component).

The action walks an input tree and produces wrapped, label, input, error and
help-text components, using recipes to customize every slot.

> [!TIP]
> #### Laravel Boost Skill
> If you use [Laravel Boost](https://laravel.com/docs/boost), install the AI skill:
> ```bash
> php artisan boost:add-skill https://github.com/juaniquillo/input-component-action
> ```

## Requirements

- PHP `^8.3`
- `juaniquillo/crud-assistant` `^0.3.0`
- `juaniquillo/laravel-backend-component`
- Laravel (for rendering)

## Install

```bash
composer require juaniquillo/input-component-action
```

The package registers `InputComponentActionServiceProvider` automatically.

## Quick start

```php
use Juaniquillo\CrudAssistant\CrudAssistant;
use Juaniquillo\CrudAssistant\Inputs\DefaultInput;
use Juaniquillo\InputComponentAction\Bags\DefaultAttributeBag;
use Juaniquillo\InputComponentAction\Containers\InputComponentOutput;
use Juaniquillo\InputComponentAction\InputComponentAction;
use Juaniquillo\InputComponentAction\Recipes\InputComponentRecipe;

$name = new DefaultInput('name', 'Name');
$name->setRecipe(new InputComponentRecipe(
    attributeBag: (new DefaultAttributeBag)->setInputAttributes([
        'placeholder' => 'Your name',
    ]),
    helpText: 'How should we call you?',
));

$crud = CrudAssistant::make([$name]);

$action = InputComponentAction::make(
    values: ['name' => 'Alice'],
    errors: ['name' => 'This field is required.'],
);

$output = $crud->execute($action);

/** @var InputComponentOutput $output */
$component = $output->inputs->get('name');
```

Render it in Blade:

```blade
{{ $component }}
```

`InputComponentOutput` exposes:

- `inputs` — one component per resolved input/collection, keyed by name
- `meta` — a `DataContainer` for action metadata

## How it works

1. `InputComponentAction` runs through CrudAssistant.
2. Each input is resolved by its **group** (`DefaultInputGroup` by default).
3. The group composes up to five **slots**:
   - wrapper
   - label
   - help text
   - input
   - error
4. Each slot is built by `SlotComposer` (or `InputComposer` for the input slot).
5. Sub-elements are built by `ChildInputResolver`, which skips inputs excluded
   by `ignore()` or `onlyFor()`.
6. The result is a `MainBackendComponent` tree ready for Blade.

## Recipes

A recipe customizes how one input is rendered. Recipes are addressed to the
action through CrudAssistant's normal `setRecipe()` API.

```php
$input->setRecipe(new InputComponentRecipe(
    attributeBag: (new DefaultAttributeBag)
        ->setWrapperAttributes(['class' => 'field'])
        ->setInputAttributes(['type' => 'email']),
    themeBag: (new DefaultThemeBag)
        ->setLabelTheme(['color' => 'gray'])
        ->setInputTheme(['inputs' => 'default']),
    disableBag: (new DefaultDisableBag)->setDisableError(),
    inputValue: fn ($input, $values, $model) => $model?->email,
    label: 'Email address',
    helpText: 'We will never share it.',
));
```

### Constructor options

`InputComponentRecipe` accepts:

| Option | Purpose |
| --- | --- |
| `inputGroup` | Group layout class |
| `themeManager` | Per-input theme manager |
| `componentBag` | Component classes/types per slot |
| `attributeBag` | Attributes per slot |
| `themeBag` | Themes per slot |
| `hookBag` | Hooks per slot |
| `valueBag` | Custom value manager |
| `errorBag` | Custom error manager |
| `disableBag` | Disable flags |
| `inputValue` | Value or value closure |
| `inputError` | Error or error closure |
| `label` | Label or label closure |
| `useParentValue` | Compare against the parent input value |
| `labelAsInputContent` | Use the label as the input content |
| `emptyLabel` | Render the label without content |
| `valueAsInputContent` | Use the value as input content |
| `helpText` | Help text or closure |
| `checkable` | Add `checked` when selected |
| `selectable` | Add `selected` when selected |
| `useParentName` | Inherit the parent input's `name` attribute |
| `useInputNameAsValue` | Fall back to the input name when no value is resolved |

### Select options

`SelectOptionComponentRecipe` extends `InputComponentRecipe` and configures the
usual option defaults:

```php
use Juaniquillo\CrudAssistant\Inputs\OptionInput;
use Juaniquillo\CrudAssistant\Inputs\SelectInput;
use Juaniquillo\BackendComponents\Enums\ComponentEnum;
use Juaniquillo\InputComponentAction\Bags\DefaultComponentBag;
use Juaniquillo\InputComponentAction\Recipes\SelectOptionComponentRecipe;

$select = new SelectInput('language', 'Language');
$select->setRecipe(new InputComponentRecipe(
    componentBag: (new DefaultComponentBag)->setInputType(ComponentEnum::SELECT),
));

$select->setSubElements(CrudAssistant::make([
    (new OptionInput('php', 'PHP'))->setRecipe(
        new SelectOptionComponentRecipe(inputValue: 'php'),
    ),
    (new OptionInput('js', 'JavaScript'))->setRecipe(
        new SelectOptionComponentRecipe(inputValue: 'js'),
    ),
]));
```

When the action receives `['language' => ['php', 'js']]`, both options are
marked selected.

### Radio and checkbox options

`RadioComponentRecipe` and `CheckboxComponentRecipe` configure a single choice
inside a group. They inherit the parent input's `name`, take the input name as
the value by default, and mark the option `checked` when it matches the parent
value:

```php
use Juaniquillo\BackendComponents\Enums\ComponentEnum;
use Juaniquillo\CrudAssistant\CrudAssistant;
use Juaniquillo\CrudAssistant\Inputs\DefaultInput;
use Juaniquillo\CrudAssistant\Inputs\RadioGroupInput;
use Juaniquillo\InputComponentAction\Bags\DefaultComponentBag;
use Juaniquillo\InputComponentAction\Recipes\InputComponentRecipe;
use Juaniquillo\InputComponentAction\Recipes\RadioComponentRecipe;

$group = new RadioGroupInput('choice', 'Choice');
$group->setRecipe(new InputComponentRecipe(
    componentBag: (new DefaultComponentBag)->setInputType(ComponentEnum::DIV),
));

$group->setSubElements(CrudAssistant::make([
    (new DefaultInput('a', 'A'))->setRecipe(new RadioComponentRecipe),
    (new DefaultInput('b', 'B'))->setRecipe(new RadioComponentRecipe),
]));
```

Use `CheckboxComponentRecipe` the same way for checkbox groups, or on its own for
a single checkbox. Both recipes only fill in defaults: a supplied component bag,
group, or disable bag is kept, so custom components (such as a switch) and
label/error groups keep working.

`SelectOptionComponentRecipe`, `RadioComponentRecipe`, and
`CheckboxComponentRecipe` share the `ChoiceComponentRecipe` base.

## Bags

All slot configuration lives in five bags.

### `DefaultComponentBag`

Component class and type per slot:

```php
$bag = (new DefaultComponentBag)
    ->setWrapperType(ComponentEnum::FIELDSET)
    ->setLabelType(ComponentEnum::LEGEND)
    ->setInputType(ComponentEnum::TEXTAREA)
    ->setErrorType(ComponentEnum::PARAGRAPH)
    ->setHelpTextType(ComponentEnum::SMALL);
```

Custom component classes or closures:

```php
$bag->setInputComponent(
    fn (string|BackedEnum $type, ThemeManager $manager) => new MyInput($type, $manager),
);
```

### `DefaultAttributeBag`

```php
(new DefaultAttributeBag)
    ->setWrapperAttributes(['class' => 'field'])
    ->setLabelAttributes(['class' => 'field-label'])
    ->setInputAttributes(['placeholder' => 'Type here'])
    ->setErrorAttributes(['class' => 'field-error'])
    ->setHelpTextAttributes(['class' => 'field-help']);
```

Every slot accepts an array or a closure:

```php
->setInputAttributes(fn ($input, $type) => [
    'name' => $input->getName(),
    'data-type' => $type instanceof BackedEnum ? $type->value : $type,
]);
```

### `DefaultThemeBag`

```php
(new DefaultThemeBag)
    ->setWrapperTheme(['forms' => 'one-column'])
    ->setLabelTheme(['color' => 'gray'])
    ->setInputTheme(['inputs' => 'default'])
    ->setErrorTheme(['color' => 'red'])
    ->setHelpTextTheme(['font' => 'sm']);
```

### `DefaultHookBag`

Hooks receive the built component and can replace or mutate it:

```php
(new DefaultHookBag)->setInputHook(
    function (BackendComponent $component, InputInterface $input): BackendComponent {
        return $component->setAttribute('data-hook', 'yes');
    },
);
```

Available hooks: `input`, `wrapper`, `label`, `error`, `helpText`.

### `DefaultDisableBag`

```php
(new DefaultDisableBag)
    ->setDisableWrapper()
    ->setDisableLabel()
    ->setDisableError()
    ->setDisableHelpText()
    ->setDisableInputValue()
    ->setDisableDefaultNameAttribute()
    ->setDisableDefaultIdAttribute()
    ->setDisableDefaultForAttribute();
```

## Slots

`Enums\Slot` identifies each slot and its default component type:

| Slot | Default |
| --- | --- |
| `Slot::WRAPPER` | `div` |
| `Slot::LABEL` | `label` |
| `Slot::INPUT` | `text` input |
| `Slot::ERROR` | `paragraph` |
| `Slot::HELP_TEXT` | `div` |

`Support::resolveType($recipe, Slot::INPUT, $bag)` resolves the effective type
with this priority:

1. recipe component bag
2. action/default component bag
3. `Slot::defaultType()`

## Groups

Set a group per input or as the action default:

```php
use Juaniquillo\InputComponentAction\Groups\LabelHelpTextInputErrorGroup;

$input->setRecipe(new InputComponentRecipe(
    inputGroup: new LabelHelpTextInputErrorGroup,
));

$action->setDefaultInputGroup(LabelHelpTextInputErrorGroup::class);
```

Built-in groups:

| Group | Slots |
| --- | --- |
| `DefaultInputGroup` | label, input, error |
| `InputErrorGroup` | input, error |
| `InputLabelErrorGroup` | input, label, error |
| `LabelHelpTextInputErrorGroup` | label, help text, input, error |
| `LabelContainerGroup` | label wrapping input, error |
| `SoleInputGroup` | input |
| `NoWrapInputGroup` | label, input, error (no wrapper element) |
| `NoWrapSoleInputGroup` | input (no wrapper element) |

### Custom groups

Extend `AbstractInputGroup` and declare the slot order:

```php
use Juaniquillo\InputComponentAction\Enums\Slot;
use Juaniquillo\InputComponentAction\Groups\AbstractInputGroup;

final class MyGroup extends AbstractInputGroup
{
    protected array $slots = [Slot::LABEL, Slot::INPUT, Slot::ERROR];
}
```

Or implement `InputGroup` with `IsInputGroup` and the `Has*` traits for full
control:

```php
final class LabelGroup implements InputGroup
{
    use HasLabel, HasWrapper, IsInputGroup;

    public function getGroup(): BackendComponent|ContentComponent
    {
        $wrapper = $this->getWrapperComponent() ?? Support::getCollectionWrapper();

        return $wrapper->setContents([
            $this->getLabelComponent(),
            $this->getInputComponent(),
        ]);
    }
}
```

## Action configuration

```php
$action = (new InputComponentAction($values, $errors))
    ->setDefaultInputGroup(LabelHelpTextInputErrorGroup::class)
    ->setDefaultComponentBag($componentBag)
    ->setDefaultThemeBag($themeBag)
    ->setThemeManager(DefaultThemeManager::class)
    ->setModel($model)
    ->setValueManager($valueManager)
    ->setErrorManager($errorManager);
```

- `setThemeManager()` accepts a class string, a closure returning a
  `ThemeManager`, or `null` (uses `LocalThemeManager`).
- `setDefaultInputGroup()` accepts a class string, a closure returning an
  `InputGroup`, or `null` (uses `DefaultInputGroup`).
- `setModel()` is used as the final value fallback.
- `setValueManager()` / `setErrorManager()` can override the resolvers globally.

### Value resolution

Default priority:

1. `values` array passed to the action
2. recipe `inputValue` (scalar or closure)
3. `model->{name}`

A recipe `valueBag` overrides the action value manager; the action value
manager overrides `DefaultValueManager`.

### Error resolution

Default priority:

1. recipe `inputError`
2. `errors[name]` (the last entry when it is an array)

A recipe `errorBag` overrides the action error manager; the action error
manager overrides `DefaultErrorManager`.

## Models and serialization

`MainBackendComponent` can be rendered directly, serialized with
`toArray()`, or restored with the backend-components factory. The action
output only contains components; serialization is handled by the consuming
application.

## Theming

The default theme manager reads package themes. Use `DefaultThemeManager` for
package themes or `LocalThemeManager` for app themes (`resources/views/_themes`).

```php
$action->setThemeManager(LocalThemeManager::class);
```

Themes are applied per slot through `DefaultThemeBag`.

## Testing

```bash
composer test       # Pest
composer analyse    # PHPStan (level 8)
composer format     # Pint
composer qa         # format → analyse → test
```

[Laravel PAO](https://github.com/laravel/pao) is installed as a dev
dependency. Inside an AI agent it replaces the output with compact JSON; in a
normal terminal the output is unchanged.

## Upgrade

See [UPGRADE.md](UPGRADE.md) for the pre-1.0 breaking changes, including the
removal of `InputComponentRecipe::make()` and the per-slot bag contracts.

## License

MIT. See [LICENSE.md](LICENSE.md).
