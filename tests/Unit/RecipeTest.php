<?php

declare(strict_types=1);

use Juaniquillo\InputComponentAction\Bags\DefaultDisableBag;
use Juaniquillo\InputComponentAction\Recipes\InputComponentRecipe;

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
