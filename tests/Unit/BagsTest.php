<?php

declare(strict_types=1);

namespace Tests\Unit;

use Closure;
use Juaniquillo\BackendComponents\Enums\ComponentEnum;
use Juaniquillo\BackendComponents\MainBackendComponent;
use Juaniquillo\BackendComponents\Themes\DefaultThemeManager;
use Juaniquillo\BaseBackendComponent\Contracts\BackendComponent;
use Juaniquillo\CrudAssistant\Contracts\InputInterface;
use Juaniquillo\InputComponentAction\Bags\DefaultAttributeBag;
use Juaniquillo\InputComponentAction\Bags\DefaultComponentBag;
use Juaniquillo\InputComponentAction\Bags\DefaultDisableBag;
use Juaniquillo\InputComponentAction\Bags\DefaultHookBag;
use Juaniquillo\InputComponentAction\Bags\DefaultThemeBag;

test('the default theme bag stores themes per slot', function (): void {
    $bag = new DefaultThemeBag;

    $bag->setWrapperTheme(['margin' => 'top-sm'])
        ->setLabelTheme(['color' => 'gray'])
        ->setInputTheme(['border' => 'sm'])
        ->setErrorTheme(['color' => 'red'])
        ->setHelpTextTheme(['font' => 'sm']);

    expect($bag->getWrapperTheme())->toBe(['margin' => 'top-sm'])
        ->and($bag->getLabelTheme())->toBe(['color' => 'gray'])
        ->and($bag->getInputTheme())->toBe(['border' => 'sm'])
        ->and($bag->getErrorTheme())->toBe(['color' => 'red'])
        ->and($bag->getHelpTextTheme())->toBe(['font' => 'sm']);
});

test('the default theme bag accepts closures', function (): void {
    $bag = new DefaultThemeBag;
    $wrapper = fn (InputInterface $input, mixed $type): array => ['slot' => $input->getName()];
    $label = fn (): array => ['label' => 'one'];

    $bag->setWrapperTheme($wrapper)->setLabelTheme($label);

    expect($bag->getWrapperTheme())->toBe($wrapper)
        ->and($bag->getLabelTheme())->toBe($label);
});

test('the default attribute bag stores attributes per slot', function (): void {
    $bag = new DefaultAttributeBag;

    $bag->setWrapperAttributes(['class' => 'wrapper'])
        ->setLabelAttributes(['class' => 'label'])
        ->setInputAttributes(['placeholder' => 'Type'])
        ->setErrorAttributes(['class' => 'error'])
        ->setHelpTextAttributes(['class' => 'help']);

    expect($bag->getWrapperAttributes())->toBe(['class' => 'wrapper'])
        ->and($bag->getLabelAttributes())->toBe(['class' => 'label'])
        ->and($bag->getInputAttributes())->toBe(['placeholder' => 'Type'])
        ->and($bag->getErrorAttributes())->toBe(['class' => 'error'])
        ->and($bag->getHelpTextAttributes())->toBe(['class' => 'help']);
});

test('the default attribute bag accepts closures', function (): void {
    $bag = new DefaultAttributeBag;
    $input = fn (): array => ['name' => 'from-closure'];
    $wrapper = fn (): array => ['class' => 'wrapper'];

    $bag->setInputAttributes($input)->setWrapperAttributes($wrapper);

    expect($bag->getInputAttributes())->toBe($input)
        ->and($bag->getWrapperAttributes())->toBe($wrapper);
});

test('the default hook bag stores hooks per slot', function (): void {
    $bag = new DefaultHookBag;

    $wrapper = static fn (): mixed => null;
    $label = static fn (): mixed => null;
    $input = static fn (): mixed => null;
    $error = static fn (): mixed => null;
    $helpText = static fn (): mixed => null;

    $bag->setWrapperHook($wrapper)
        ->setLabelHook($label)
        ->setInputHook($input)
        ->setErrorHook($error)
        ->setHelpTextHook($helpText);

    expect($bag->getWrapperHook())->toBe($wrapper)
        ->and($bag->getLabelHook())->toBe($label)
        ->and($bag->getInputHook())->toBe($input)
        ->and($bag->getErrorHook())->toBe($error)
        ->and($bag->getHelpTextHook())->toBe($helpText);
});

test('the default disable bag defaults every flag to false', function (): void {
    $bag = new DefaultDisableBag;

    expect($bag->disableWrapper())->toBeFalse()
        ->and($bag->disableLabel())->toBeFalse()
        ->and($bag->disableError())->toBeFalse()
        ->and($bag->disableHelpText())->toBeFalse()
        ->and($bag->disableInputValue())->toBeFalse()
        ->and($bag->disableDefaultNameAttribute())->toBeFalse()
        ->and($bag->disableDefaultIdAttribute())->toBeFalse()
        ->and($bag->disableDefaultForAttribute())->toBeFalse();
});

test('the default disable bag can toggle every flag', function (): void {
    $bag = new DefaultDisableBag;

    $bag->setDisableWrapper()
        ->setDisableLabel()
        ->setDisableError()
        ->setDisableHelpText()
        ->setDisableInputValue()
        ->setDisableDefaultNameAttribute()
        ->setDisableDefaultIdAttribute()
        ->setDisableDefaultForAttribute();

    expect($bag->disableWrapper())->toBeTrue()
        ->and($bag->disableLabel())->toBeTrue()
        ->and($bag->disableError())->toBeTrue()
        ->and($bag->disableHelpText())->toBeTrue()
        ->and($bag->disableInputValue())->toBeTrue()
        ->and($bag->disableDefaultNameAttribute())->toBeTrue()
        ->and($bag->disableDefaultIdAttribute())->toBeTrue()
        ->and($bag->disableDefaultForAttribute())->toBeTrue();

    $bag->setDisableWrapper(false)
        ->setDisableLabel(false)
        ->setDisableError(false)
        ->setDisableHelpText(false)
        ->setDisableInputValue(false)
        ->setDisableDefaultNameAttribute(false)
        ->setDisableDefaultIdAttribute(false)
        ->setDisableDefaultForAttribute(false);

    expect($bag->disableWrapper())->toBeFalse()
        ->and($bag->disableLabel())->toBeFalse()
        ->and($bag->disableError())->toBeFalse()
        ->and($bag->disableHelpText())->toBeFalse()
        ->and($bag->disableInputValue())->toBeFalse()
        ->and($bag->disableDefaultNameAttribute())->toBeFalse()
        ->and($bag->disableDefaultIdAttribute())->toBeFalse()
        ->and($bag->disableDefaultForAttribute())->toBeFalse();
});

test('the default component bag stores components and types per slot', function (): void {
    $bag = new DefaultComponentBag;
    $component = static fn (string $type, $manager): BackendComponent => new MainBackendComponent($type, $manager);

    $bag->setWrapperComponent($component)
        ->setLabelComponent($component)
        ->setInputComponent($component)
        ->setErrorComponent($component)
        ->setHelpTextComponent($component)
        ->setWrapperType(ComponentEnum::FIELDSET)
        ->setLabelType(ComponentEnum::LEGEND)
        ->setInputType(ComponentEnum::TEXTAREA)
        ->setErrorType(ComponentEnum::PARAGRAPH)
        ->setHelpTextType(ComponentEnum::SMALL);

    expect($bag->getWrapperComponent())->toBe($component)
        ->and($bag->getLabelComponent())->toBe($component)
        ->and($bag->getInputComponent())->toBe($component)
        ->and($bag->getErrorComponent())->toBe($component)
        ->and($bag->getHelpTextComponent())->toBe($component)
        ->and($bag->getWrapperType())->toBe(ComponentEnum::FIELDSET)
        ->and($bag->getLabelType())->toBe(ComponentEnum::LEGEND)
        ->and($bag->getInputType())->toBe(ComponentEnum::TEXTAREA)
        ->and($bag->getErrorType())->toBe(ComponentEnum::PARAGRAPH)
        ->and($bag->getHelpTextType())->toBe(ComponentEnum::SMALL);
});

test('the default component bag does not require a theme manager argument in components', function (): void {
    $bag = new DefaultComponentBag;
    $component = static fn (): BackendComponent => new MainBackendComponent(ComponentEnum::DIV, new DefaultThemeManager);

    $bag->setInputComponent($component);

    expect($bag->getInputComponent())->toBe($component)
        ->and($bag->getInputComponent())->toBeInstanceOf(Closure::class);
});
