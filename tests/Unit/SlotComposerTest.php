<?php

declare(strict_types=1);

namespace Tests\Unit;

use InvalidArgumentException;
use Juaniquillo\BackendComponents\Themes\DefaultThemeManager;
use Juaniquillo\CrudAssistant\Inputs\DefaultInput;
use Juaniquillo\InputComponentAction\Bags\DefaultComponentBag;
use Juaniquillo\InputComponentAction\Composers\SlotComposer;
use Juaniquillo\InputComponentAction\Enums\Slot;
use Juaniquillo\InputComponentAction\Recipes\InputComponentRecipe;

test('the slot composer rejects the input slot', function (): void {
    expect(static fn () => new SlotComposer(
        slot: Slot::INPUT,
        input: new DefaultInput('name'),
        recipe: new InputComponentRecipe,
        themeManager: new DefaultThemeManager,
        componentBag: new DefaultComponentBag,
    ))->toThrow(InvalidArgumentException::class, 'The input slot is handled by the InputComposer.');
});
