<?php

declare(strict_types=1);

use Juaniquillo\BackendComponents\Enums\ComponentEnum;
use Juaniquillo\InputComponentAction\Bags\DefaultComponentBag;
use Juaniquillo\InputComponentAction\Bags\DefaultDisableBag;
use Juaniquillo\InputComponentAction\Groups\InputLabelErrorGroup;
use Juaniquillo\InputComponentAction\Groups\SoleInputGroup;
use Juaniquillo\InputComponentAction\Recipes\CheckboxComponentRecipe;
use Juaniquillo\InputComponentAction\Recipes\RadioComponentRecipe;

test('the radio recipe applies its defaults', function (): void {
    $recipe = new RadioComponentRecipe;

    expect($recipe->getInputGroup())->toBeInstanceOf(SoleInputGroup::class)
        ->and($recipe->getComponentBag())->toBeInstanceOf(DefaultComponentBag::class)
        ->and($recipe->getComponentBag()->getInputType())->toBe(ComponentEnum::RADIO_INPUT)
        ->and($recipe->getDisableBag())->toBeInstanceOf(DefaultDisableBag::class)
        ->and($recipe->getDisableBag()->disableWrapper())->toBeTrue()
        ->and($recipe->getDisableBag()->disableDefaultNameAttribute())->toBeFalse()
        ->and($recipe->useParentValue())->toBeTrue()
        ->and($recipe->useParentName())->toBeTrue()
        ->and($recipe->useInputNameAsValue())->toBeTrue()
        ->and($recipe->isCheckable())->toBeTrue()
        ->and($recipe->isSelectable())->toBeFalse()
        ->and($recipe->labelAsInputContent())->toBeTrue();
});

test('the checkbox recipe applies its defaults', function (): void {
    $recipe = new CheckboxComponentRecipe;

    expect($recipe->getInputGroup())->toBeInstanceOf(SoleInputGroup::class)
        ->and($recipe->getComponentBag())->toBeInstanceOf(DefaultComponentBag::class)
        ->and($recipe->getComponentBag()->getInputType())->toBe(ComponentEnum::CHECKBOX_INPUT)
        ->and($recipe->getDisableBag())->toBeInstanceOf(DefaultDisableBag::class)
        ->and($recipe->getDisableBag()->disableWrapper())->toBeTrue()
        ->and($recipe->getDisableBag()->disableDefaultNameAttribute())->toBeFalse()
        ->and($recipe->useParentValue())->toBeTrue()
        ->and($recipe->useParentName())->toBeTrue()
        ->and($recipe->useInputNameAsValue())->toBeTrue()
        ->and($recipe->isCheckable())->toBeTrue()
        ->and($recipe->isSelectable())->toBeFalse()
        ->and($recipe->labelAsInputContent())->toBeTrue();
});

test('the choice recipes merge supplied bags', function (): void {
    $componentBag = new DefaultComponentBag;
    $disableBag = (new DefaultDisableBag)->setDisableError();

    $recipe = new CheckboxComponentRecipe(
        componentBag: $componentBag,
        disableBag: $disableBag,
    );

    expect($componentBag->getInputType())->toBe(ComponentEnum::CHECKBOX_INPUT)
        ->and($disableBag->disableError())->toBeTrue()
        ->and($disableBag->disableWrapper())->toBeTrue()
        ->and($recipe->getComponentBag())->toBe($componentBag)
        ->and($recipe->getDisableBag())->toBe($disableBag);
});

test('the choice recipes keep a custom input type and group', function (): void {
    $componentBag = (new DefaultComponentBag)->setInputType(ComponentEnum::EMAIL_INPUT);
    $group = new InputLabelErrorGroup;
    $disableBag = new DefaultDisableBag;

    $recipe = new RadioComponentRecipe(
        inputGroup: $group,
        componentBag: $componentBag,
        disableBag: $disableBag,
    );

    expect($componentBag->getInputType())->toBe(ComponentEnum::EMAIL_INPUT)
        ->and($recipe->getInputGroup())->toBe($group)
        ->and($recipe->labelAsInputContent())->toBeFalse()
        ->and($disableBag->disableWrapper())->toBeFalse();
});
