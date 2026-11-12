<?php

declare(strict_types=1);

namespace Tests\Unit;

use BackedEnum;
use Juaniquillo\BackendComponents\Enums\ComponentEnum;
use Juaniquillo\BackendComponents\MainBackendComponent;
use Juaniquillo\BackendComponents\Themes\DefaultThemeManager;
use Juaniquillo\BackendComponents\Themes\LocalThemeManager;
use Juaniquillo\BaseBackendComponent\Contracts\ThemeManager;
use Juaniquillo\CrudAssistant\Inputs\DefaultInput;
use Juaniquillo\CrudAssistant\Recipes\FilterRecipe;
use Juaniquillo\InputComponentAction\Bags\DefaultComponentBag;
use Juaniquillo\InputComponentAction\Enums\Slot;
use Juaniquillo\InputComponentAction\Groups\DefaultInputGroup;
use Juaniquillo\InputComponentAction\Groups\SoleInputGroup;
use Juaniquillo\InputComponentAction\Recipes\InputComponentRecipe;
use Juaniquillo\InputComponentAction\Recipes\SelectOptionComponentRecipe;
use Juaniquillo\InputComponentAction\Utilities\Support;

test('it resolves the input component recipe for the action', function (): void {
    $input = new DefaultInput('name');

    expect(Support::getRecipe($input))->toBeInstanceOf(InputComponentRecipe::class);
});

test('it returns the recipe registered for the action', function (): void {
    $input = new DefaultInput('name');
    $recipe = new InputComponentRecipe;

    $input->setRecipe($recipe);

    expect(Support::getRecipe($input))->toBe($recipe);
});

test('it ignores recipes registered for other actions', function (): void {
    $input = new DefaultInput('name');

    $input->setRecipe(new FilterRecipe);

    expect(Support::getRecipe($input))
        ->toBeInstanceOf(InputComponentRecipe::class)
        ->not->toBeInstanceOf(FilterRecipe::class);
});

test('it returns the registered select option recipe', function (): void {
    $input = new DefaultInput('option');
    $recipe = new SelectOptionComponentRecipe;

    $input->setRecipe($recipe);

    expect(Support::getRecipe($input))->toBe($recipe);
});

test('it resolves a theme manager from a class string', function (): void {
    expect(Support::resolveThemeManager(DefaultThemeManager::class))
        ->toBeInstanceOf(DefaultThemeManager::class);
});

test('it resolves a theme manager from a closure', function (): void {
    $manager = Support::resolveThemeManager(fn (): ThemeManager => new DefaultThemeManager);

    expect($manager)->toBeInstanceOf(DefaultThemeManager::class);
});

test('it falls back to the local theme manager', function (): void {
    expect(Support::resolveThemeManager(null))->toBeInstanceOf(LocalThemeManager::class);
});

test('it resolves an input group from a class string', function (): void {
    expect(Support::resolveInputGroup(SoleInputGroup::class))
        ->toBeInstanceOf(SoleInputGroup::class);
});

test('it resolves an input group from a closure', function (): void {
    expect(Support::resolveInputGroup(fn () => new SoleInputGroup))
        ->toBeInstanceOf(SoleInputGroup::class);
});

test('it falls back to the default input group', function (): void {
    expect(Support::resolveInputGroup(null))->toBeInstanceOf(DefaultInputGroup::class);
});

test('it resolves a component from a class string', function (): void {
    $themeManager = new DefaultThemeManager;

    $component = Support::resolveComponent(
        component: MainBackendComponent::class,
        type: ComponentEnum::DIV,
        themeManager: $themeManager,
    );

    expect($component)->toBeInstanceOf(MainBackendComponent::class)
        ->and($component->getName())->toBe(ComponentEnum::DIV->value);
});

test('it resolves a component from a closure', function (): void {
    $themeManager = new DefaultThemeManager;

    $component = Support::resolveComponent(
        component: fn (string|BackedEnum $type, ThemeManager $manager): MainBackendComponent => new MainBackendComponent($type, $manager),
        type: ComponentEnum::SPAN,
        themeManager: $themeManager,
    );

    expect($component)->toBeInstanceOf(MainBackendComponent::class)
        ->and($component->getName())->toBe(ComponentEnum::SPAN->value);
});

test('it falls back to a main backend component', function (): void {
    $component = Support::resolveComponent(
        component: null,
        type: ComponentEnum::DIV,
        themeManager: new DefaultThemeManager,
    );

    expect($component)->toBeInstanceOf(MainBackendComponent::class)
        ->and($component->getName())->toBe(ComponentEnum::DIV->value);
});

test('it resolves slot types with recipe, default bag and global fallbacks', function (): void {
    $themeManager = new DefaultThemeManager;
    $recipeBag = (new DefaultComponentBag)
        ->setWrapperType(ComponentEnum::FIELDSET)
        ->setLabelType(ComponentEnum::LEGEND)
        ->setInputType(ComponentEnum::TEXTAREA)
        ->setErrorType(ComponentEnum::SPAN)
        ->setHelpTextType(ComponentEnum::SMALL);

    $recipe = new InputComponentRecipe(componentBag: $recipeBag);
    $defaultBag = (new DefaultComponentBag)
        ->setWrapperType(ComponentEnum::DIV)
        ->setLabelType(ComponentEnum::LABEL)
        ->setInputType(ComponentEnum::TEXT_INPUT)
        ->setErrorType(ComponentEnum::PARAGRAPH)
        ->setHelpTextType(ComponentEnum::DIV);

    expect(Support::resolveType($recipe, Slot::WRAPPER, $defaultBag))->toBe(ComponentEnum::FIELDSET)
        ->and(Support::resolveType($recipe, Slot::LABEL, $defaultBag))->toBe(ComponentEnum::LEGEND)
        ->and(Support::resolveType($recipe, Slot::INPUT, $defaultBag))->toBe(ComponentEnum::TEXTAREA)
        ->and(Support::resolveType($recipe, Slot::ERROR, $defaultBag))->toBe(ComponentEnum::SPAN);
});

test('it uses the default component bag when the recipe has no component bag', function (): void {
    $defaultBag = (new DefaultComponentBag)
        ->setWrapperType(ComponentEnum::FIELDSET)
        ->setLabelType(ComponentEnum::LEGEND)
        ->setInputType(ComponentEnum::TEXTAREA)
        ->setErrorType(ComponentEnum::PARAGRAPH)
        ->setHelpTextType(ComponentEnum::SMALL);

    $recipe = new InputComponentRecipe;

    expect(Support::resolveType($recipe, Slot::WRAPPER, $defaultBag))->toBe(ComponentEnum::FIELDSET)
        ->and(Support::resolveType($recipe, Slot::LABEL, $defaultBag))->toBe(ComponentEnum::LEGEND)
        ->and(Support::resolveType($recipe, Slot::INPUT, $defaultBag))->toBe(ComponentEnum::TEXTAREA)
        ->and(Support::resolveType($recipe, Slot::ERROR, $defaultBag))->toBe(ComponentEnum::PARAGRAPH)
        ->and(Support::resolveType($recipe, Slot::HELP_TEXT, $defaultBag))->toBe(ComponentEnum::SMALL);
});

test('it resolves every slot through the generic type resolver', function (): void {
    $bag = (new DefaultComponentBag)
        ->setWrapperType(ComponentEnum::FIELDSET)
        ->setLabelType(ComponentEnum::LEGEND)
        ->setInputType(ComponentEnum::TEXTAREA)
        ->setErrorType(ComponentEnum::SPAN)
        ->setHelpTextType(ComponentEnum::SMALL);

    $recipe = new InputComponentRecipe;

    expect(Support::resolveType($recipe, Slot::WRAPPER, $bag))->toBe(ComponentEnum::FIELDSET)
        ->and(Support::resolveType($recipe, Slot::LABEL, $bag))->toBe(ComponentEnum::LEGEND)
        ->and(Support::resolveType($recipe, Slot::INPUT, $bag))->toBe(ComponentEnum::TEXTAREA)
        ->and(Support::resolveType($recipe, Slot::ERROR, $bag))->toBe(ComponentEnum::SPAN)
        ->and(Support::resolveType($recipe, Slot::HELP_TEXT, $bag))->toBe(ComponentEnum::SMALL);
});

test('the slot enum exposes its default component types', function (): void {
    expect(Slot::WRAPPER->defaultType())->toBe(ComponentEnum::DIV)
        ->and(Slot::LABEL->defaultType())->toBe(ComponentEnum::LABEL)
        ->and(Slot::INPUT->defaultType())->toBe(ComponentEnum::TEXT_INPUT)
        ->and(Slot::ERROR->defaultType())->toBe(ComponentEnum::PARAGRAPH)
        ->and(Slot::HELP_TEXT->defaultType())->toBe(ComponentEnum::DIV);
});

test('it resolves the help text type from the recipe component bag', function (): void {
    $recipe = new InputComponentRecipe(componentBag: (new DefaultComponentBag)
        ->setErrorType(ComponentEnum::SPAN)
        ->setHelpTextType(ComponentEnum::SMALL));
    $defaultBag = (new DefaultComponentBag)->setHelpTextType(ComponentEnum::DIV);

    expect(Support::resolveType($recipe, Slot::HELP_TEXT, $defaultBag))->toBe(ComponentEnum::SMALL);
});

test('it falls back to the global slot types', function (): void {
    $bag = new DefaultComponentBag;
    $recipe = new InputComponentRecipe;

    expect(Support::resolveType($recipe, Slot::WRAPPER, $bag))->toBe(ComponentEnum::DIV)
        ->and(Support::resolveType($recipe, Slot::LABEL, $bag))->toBe(ComponentEnum::LABEL)
        ->and(Support::resolveType($recipe, Slot::INPUT, $bag))->toBe(ComponentEnum::TEXT_INPUT)
        ->and(Support::resolveType($recipe, Slot::ERROR, $bag))->toBe(ComponentEnum::PARAGRAPH)
        ->and(Support::resolveType($recipe, Slot::HELP_TEXT, $bag))->toBe(ComponentEnum::DIV);
});

test('it resolves slot types without a recipe', function (): void {
    $bag = new DefaultComponentBag;

    expect(Support::resolveType(null, Slot::WRAPPER, $bag))->toBe(ComponentEnum::DIV)
        ->and(Support::resolveType(null, Slot::LABEL, $bag))->toBe(ComponentEnum::LABEL)
        ->and(Support::resolveType(null, Slot::INPUT, $bag))->toBe(ComponentEnum::TEXT_INPUT)
        ->and(Support::resolveType(null, Slot::ERROR, $bag))->toBe(ComponentEnum::PARAGRAPH)
        ->and(Support::resolveType(null, Slot::HELP_TEXT, $bag))->toBe(ComponentEnum::DIV);
});

test('it builds a collection wrapper', function (): void {
    $wrapper = Support::getCollectionWrapper();

    expect($wrapper)->toBeInstanceOf(MainBackendComponent::class)
        ->and($wrapper->getName())->toBe(ComponentEnum::COLLECTION->value);
});
