<?php

declare(strict_types=1);

namespace Tests\Unit;

use Juaniquillo\BackendComponents\Contracts\BackendComponent;
use Juaniquillo\BackendComponents\Contracts\CompoundComponent;
use Juaniquillo\BackendComponents\Contracts\StaticBuilder;
use Juaniquillo\BackendComponents\Contracts\ThemeManager;
use Juaniquillo\BackendComponents\MainBackendComponent;
use Juaniquillo\InputComponentAction\Bags\DefaultComponentBag;
use Juaniquillo\InputComponentAction\Contracts\ComponentBag;
use Juaniquillo\InputComponentAction\Contracts\ErrorComponent;
use Juaniquillo\InputComponentAction\Contracts\HelpTextComponent;
use Juaniquillo\InputComponentAction\Contracts\LabelComponent;
use Juaniquillo\InputComponentAction\Contracts\WrapperComponent;
use Juaniquillo\InputComponentAction\Utilities\Support;
use Mockery;

test('DefaultComponentBag implements all component interfaces', function () {
    $bag = new DefaultComponentBag();

    expect($bag)->toBeInstanceOf(ComponentBag::class)
        ->toBeInstanceOf(WrapperComponent::class)
        ->toBeInstanceOf(LabelComponent::class)
        ->toBeInstanceOf(ErrorComponent::class)
        ->toBeInstanceOf(HelpTextComponent::class);
});

test('DefaultComponentBag can set and get all components', function () {
    $bag = new DefaultComponentBag();
    
    $input = Mockery::mock(CompoundComponent::class);
    $wrapper = Mockery::mock(CompoundComponent::class);
    $label = Mockery::mock(CompoundComponent::class);
    $error = Mockery::mock(CompoundComponent::class);
    $helpText = Mockery::mock(CompoundComponent::class);

    $bag->setInputComponent($input)
        ->setWrapperComponent($wrapper)
        ->setLabelComponent($label)
        ->setErrorComponent($error)
        ->setHelpTextComponent($helpText);

    expect($bag->getInputComponent())->toBe($input)
        ->and($bag->getWrapperComponent())->toBe($wrapper)
        ->and($bag->getLabelComponent())->toBe($label)
        ->and($bag->getErrorComponent())->toBe($error)
        ->and($bag->getHelpTextComponent())->toBe($helpText);
});

test('Support::resolveComponent handles different types', function () {
    $themeManager = Mockery::mock(ThemeManager::class);
    $type = 'div';

    // 1. Null component returns MainBackendComponent
    $resolved = Support::resolveComponent(null, $type, $themeManager);
    expect($resolved)->toBeInstanceOf(MainBackendComponent::class);

    // 2. Closure resolution
    $resolved = Support::resolveComponent(fn() => 'from closure', $type, $themeManager);
    expect($resolved)->toBe('from closure');

    // 3. Class string resolution
    $resolved = Support::resolveComponent(MainBackendComponent::class, $type, $themeManager);
    expect($resolved)->toBeInstanceOf(MainBackendComponent::class);

    // 4. Instance resolution
    $instance = new MainBackendComponent($type, $themeManager);
    $resolved = Support::resolveComponent($instance, $type, $themeManager);
    expect($resolved)->toBe($instance);

    // 5. StaticBuilder resolution
    $builder = Mockery::mock(StaticBuilder::class);
    $builder->shouldReceive('make')
        ->with($type, $themeManager)
        ->andReturn($instance);
    
    $resolved = Support::resolveComponent($builder, $type, $themeManager);
    expect($resolved)->toBe($instance);
});
