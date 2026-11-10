# Upgrade Guide

This package is pre-1.0. This guide covers the API cleanup and behavior
changes in the current rewrite.

> **Dependency note:** this version targets `juaniquillo/crud-assistant`
> `^0.3.0`. If your app is still on `0.2.x`, upgrade CrudAssistant first and
> follow its own upgrade guide.
>
> It also requires `juaniquillo/laravel-backend-component` `^0.11.0`, where the
> former builders are now factories. This package does not wrap those classes;
> follow the upstream upgrade guide if your app uses them directly.

## 1. Per-slot bag contracts and traits removed

The five bags now own every slot. The 21 per-slot contracts and their 21
traits are gone.

**Removed contracts:**

- `WrapperComponent`, `LabelComponent`, `ErrorComponent`, `HelpTextComponent`
- `WrapperAttributes`, `LabelAttributes`, `ErrorAttributes`, `HelpTextAttributes`
- `WrapperTheme`, `LabelTheme`, `ErrorTheme`, `HelpTextTheme`
- `WrapperHook`, `LabelHook`, `ErrorHook`, `HelpTextHook`
- `WrapperDisable`, `LabelDisable`, `ErrorDisable`, `HelpTextDisable`, `InputDisable`

**Use instead:**

| Removed family | Replacement |
| --- | --- |
| component/type per slot | `ComponentBag` |
| attributes per slot | `AttributeBag` |
| themes per slot | `ThemeBag` |
| hooks per slot | `HookBag` |
| disable flags | `DisableBag` |

The `Default*Bag` classes still expose the same fluent methods
(`setInputType()`, `setWrapperTheme()`, `setDisableWrapper()`, …), so normal
usage does not change:

```php
use Juaniquillo\InputComponentAction\Bags\DefaultComponentBag;

$bag = (new DefaultComponentBag)
    ->setWrapperType(ComponentEnum::FIELDSET)
    ->setInputType(ComponentEnum::TEXTAREA);
```

Only custom classes that implement the removed interfaces need to change:

```php
// Before
use Juaniquillo\InputComponentAction\Contracts\WrapperTheme;

final class MyBag implements WrapperTheme { /* ... */ }

// After
use Juaniquillo\InputComponentAction\Contracts\ThemeBag;

final class MyBag implements ThemeBag
{
    use \Juaniquillo\InputComponentAction\Concerns\IsThemeBag;
}
```

Also removed:

- `Contracts\BuilderBag` (unused)
- `Contracts\ComponentComposer` (internal)
- `Composers\WrapperComposer`, `LabelComposer`, `ErrorComposer`, `HelpTextComposer`
  (replaced by `Composers\SlotComposer` + `Composers\InputComposer`)

## 2. Recipe factory removed

`InputComponentRecipe::make()` and the corresponding
`InputComponentRecipeInterface::make()` method have been removed.

```php
// Before
$recipe = InputComponentRecipe::make();

// After
$recipe = new InputComponentRecipe;
```

The constructor is the only supported way to build a recipe.

`SelectOptionComponentRecipe` now extends `InputComponentRecipe` instead of
duplicating its constructor. It inherits every recipe option and forces the
option defaults through `configure()`:

```php
use Juaniquillo\InputComponentAction\Recipes\SelectOptionComponentRecipe;

$option = new SelectOptionComponentRecipe(
    inputValue: 'php',
    label: 'PHP',
);
```

It still defaults to `SoleInputGroup`, the `option` component type, disabled
wrapper/default name, `useParentValue`, `selectable`, and
`labelAsInputContent`. Explicit `inputGroup`, `componentBag`, and
`disableBag` values are preserved.

### Recipe-level type setters removed

The following were dead API (types were always read from the component bag):

```php
// Removed
$recipe->setWrapperType(...);
$recipe->setLabelType(...);
$recipe->setInputType(...);
$recipe->setErrorType(...);
$recipe->setHelpTextType(...);
```

Put those values on the component bag instead:

```php
new InputComponentRecipe(
    componentBag: (new DefaultComponentBag)
        ->setWrapperType(ComponentEnum::FIELDSET)
        ->setInputType(ComponentEnum::TEXTAREA),
);
```

## 3. Group API

`InputGroup::inject()` now receives a single `GroupContext` instead of nine
positional arguments:

```php
// Before
$group->inject(
    input: $input,
    recipe: $recipe,
    themeManager: $manager,
    defaultThemeManager: null,
    defaultComponentBag: $componentBag,
    defaultInputGroup: DefaultInputGroup::class,
    values: $values,
    errors: $errors,
    defaultThemeBag: $bag,
);

// After
$group->inject(new GroupContext(
    input: $input,
    recipe: $recipe,
    eligibility: new InputEligibility(InputComponentAction::getIdentifier()),
    themeManager: $manager,
    defaultThemeManager: null,
    defaultComponentBag: $componentBag,
    defaultInputGroup: DefaultInputGroup::class,
    values: $values,
    errors: $errors,
    defaultThemeBag: $bag,
));
```

`setParent()` was removed from the group contract; the parent travels in
`GroupContext`. Custom groups built with `IsInputGroup` do not need changes.
Groups that override `inject()` must update the signature.

Eligibility (`ignore()` / `onlyFor()`) is now centralized in
`Resolvers\InputEligibility`. The action uses it while walking collections, and
`Resolvers\ChildInputResolver` uses it for sub-elements. `GroupContext`
carries the eligibility instance so nested groups resolve with the same action
identifier.

A new `AbstractInputGroup` is available. It owns the slot order, wrapping,
label-container and required-label behavior, so a custom group can be just:

```php
final class MyGroup extends AbstractInputGroup
{
    protected array $slots = [Slot::LABEL, Slot::INPUT, Slot::ERROR];
}
```

Package groups now extend it. `InputGroupFactory::init()` takes a
`GroupContext` and validates that the resulting component is renderable.

## 4. Support helpers

Removed from `Utilities\Support`:

- `resolveWrapperType()`, `resolveLabelType()`, `resolveInputType()`,
  `resolveErrorType()`, `resolveHelpTextType()`
- `isClosure()`
- `resolveThemeBag()`

Replacements:

```php
// Before
Support::resolveInputType($recipe, $bag);

// After
Support::resolveType($recipe, Slot::INPUT, $bag);
```

```php
// Before
Support::isClosure($value);

// After
$value instanceof Closure;
```

`Support::resolveType()` returns the recipe bag type, then the default bag
type, then `Slot::defaultType()`.

`Defaults\InputTypes` was removed. Use `Slot::defaultType()` or
`ComponentEnum` directly:

```php
Slot::ERROR->defaultType(); // ComponentEnum::PARAGRAPH
```

`Slot` cases are uppercase: `WRAPPER`, `LABEL`, `INPUT`, `ERROR`, `HELP_TEXT`.

## 5. Managers and action contracts

`ValueManager::setModel()` now accepts a nullable model:

```php
// Before
public function setModel(object $model): static;

// After
public function setModel(?object $model): static;
```

Custom managers must accept `null`. The `IsValueManager` trait already does.

Array shapes are now documented for values, errors, attributes and themes;
custom implementations should match them for static analysis.

`InputComponentActionInterface::resolveInputs()` and `getWrapper()` now use
intersection return types (`BackendComponent&ContentComponent&ThemeComponent`).
Custom action implementations should update their signatures.

`InputComponentOutput` specifies its `DataContainer` generics; no runtime
change.

## 6. Renderable component requirement

Composers now require a component that implements all of:

- `BackendComponent`
- `ContentComponent`
- `ThemeComponent`

This applies to custom component classes/closures, component hooks, and
modifiers. `MainBackendComponent` (and therefore `CompoundComponent`)
satisfies all three. Invalid results throw a clear exception or fall back to
`MainBackendComponent` during resolution.

## 7. Behavior changes

- Error components default to `paragraph` instead of `div`.
- Empty errors are omitted instead of rendering an empty element.
- Error attributes are applied.
- Error arrays use the last entry.
- Array values are no longer stringified; multi-select/checkbox membership
  works with parent arrays.
- Closure-based input attributes are resolved before deriving `name`/`id`.
- Null labels no longer cause a `TypeError`.
- Recursive resolution honors `ignore()` and `onlyFor()`.
- Sub-elements honor `ignore()` and `onlyFor()` too; ineligible sub-elements
  are skipped and an empty result omits the input contents.
- Collection wrapper hooks receive the value and error managers.
- Help text `'0'` is rendered.

## 8. Migration checklist

Search your application for:

```bash
grep -rn "InputComponentRecipe::make\|SelectOptionComponentRecipe::make" app
grep -rn "Support::isClosure\|resolveWrapperType\|resolveLabelType\|resolveInputType\|resolveErrorType\|resolveHelpTextType" app
grep -rn "Contracts\\\\Wrapper\|Contracts\\\\Label\|Contracts\\\\Error\|Contracts\\\\HelpText\|Contracts\\\\InputDisable" app
grep -rn "InputTypes" app
grep -rn "function inject(" app
grep -rn "RecipeContainer" app
```

Then:

1. Replace recipe `make()` calls with `new`.
2. Replace removed `Support::*` helpers.
3. Replace per-slot bag implementations with the base bags.
4. Update custom group `inject()` overrides.
5. Ensure custom components/hooks/modifiers return a renderable component.
6. Update custom `ValueManager::setModel()` signatures.
7. Run your test suite, paying attention to error rendering and multi-select
   values.
