<?php

declare(strict_types=1);

namespace Tests\Unit;

use Juaniquillo\BackendComponents\Contracts\ThemeManager;
use Juaniquillo\BackendComponents\Enums\ComponentEnum;
use Juaniquillo\BackendComponents\MainBackendComponent;
use Juaniquillo\BackendComponents\Themes\DefaultThemeManager;
use Juaniquillo\InputComponentAction\Bags\DefaultComponentBag;
use Juaniquillo\InputComponentAction\Contracts\ComponentBag;
use Juaniquillo\InputComponentAction\Contracts\ErrorComponent;
use Juaniquillo\InputComponentAction\Contracts\HelpTextComponent;
use Juaniquillo\InputComponentAction\Contracts\LabelComponent;
use Juaniquillo\InputComponentAction\Contracts\WrapperComponent;
use Juaniquillo\InputComponentAction\Utilities\Support;

test('DefaultComponentBag implements all component interfaces', function () {
    $bag = new DefaultComponentBag;

    expect($bag)->toBeInstanceOf(ComponentBag::class)
        ->toBeInstanceOf(WrapperComponent::class)
        ->toBeInstanceOf(LabelComponent::class)
        ->toBeInstanceOf(ErrorComponent::class)
        ->toBeInstanceOf(HelpTextComponent::class);
});

test('DefaultComponentBag can set and get all components', function () {
    $bag = new DefaultComponentBag;

    $bag->setInputComponent(function (string $type, ThemeManager $themeManager) {
        return new MainBackendComponent($type, $themeManager);
    })
        ->setWrapperComponent(function (string $type, ThemeManager $themeManager) {
            return new MainBackendComponent($type, $themeManager);

        })
        ->setLabelComponent(function (string $type, ThemeManager $themeManager) {
            return new MainBackendComponent($type, $themeManager);

        })
        ->setErrorComponent(function (string $type, ThemeManager $themeManager) {
            return new MainBackendComponent($type, $themeManager);
        })
        ->setHelpTextComponent(function (string $type, ThemeManager $themeManager) {
            return new MainBackendComponent($type, $themeManager);
        });

    expect($bag->getInputComponent())->toBe($bag->getInputComponent())
        ->and($bag->getWrapperComponent())->toBe($bag->getWrapperComponent())
        ->and($bag->getLabelComponent())->toBe($bag->getLabelComponent())
        ->and($bag->getErrorComponent())->toBe($bag->getErrorComponent())
        ->and($bag->getHelpTextComponent())->toBe($bag->getHelpTextComponent());
});

test('Support::resolveComponent handles different types', function () {
    $themeManager = new DefaultThemeManager;
    $type = ComponentEnum::DIV;

    // 1. Null component returns MainBackendComponent
    $resolved = Support::resolveComponent(null, $type, $themeManager);
    expect($resolved)->toBeInstanceOf(MainBackendComponent::class);

    // 2. Closure resolution
    $resolved = Support::resolveComponent(fn () => 'from closure', $type, $themeManager);
    expect($resolved)->toBe('from closure');

    // 3. Class string resolution
    $resolved = Support::resolveComponent(MainBackendComponent::class, $type, $themeManager);
    expect($resolved)->toBeInstanceOf(MainBackendComponent::class);

});
