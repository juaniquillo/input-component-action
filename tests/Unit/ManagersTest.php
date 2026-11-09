<?php

declare(strict_types=1);

namespace Tests\Unit;

use Juaniquillo\CrudAssistant\Contracts\InputInterface;
use Juaniquillo\CrudAssistant\Inputs\DefaultInput;
use Juaniquillo\InputComponentAction\Managers\DefaultErrorManager;
use Juaniquillo\InputComponentAction\Managers\DefaultValueManager;
use Juaniquillo\InputComponentAction\Recipes\InputComponentRecipe;
use Stringable;

test('the default value manager prioritizes the values array', function (): void {
    $input = new DefaultInput('name');
    $recipe = new InputComponentRecipe(inputValue: 'recipe-value');
    $model = (object) ['name' => 'model-value'];

    $manager = (new DefaultValueManager)
        ->setValues(['name' => 'array-value'])
        ->setModel($model);

    expect($manager->resolve($input, $recipe))->toBe('array-value');
});

test('the default value manager falls back to the recipe value', function (): void {
    $input = new DefaultInput('name');
    $recipe = new InputComponentRecipe(inputValue: 'recipe-value');
    $model = (object) ['name' => 'model-value'];

    $manager = (new DefaultValueManager)->setModel($model);

    expect($manager->resolve($input, $recipe))->toBe('recipe-value');
});

test('the default value manager resolves recipe closures with the input, values and model', function (): void {
    $input = new DefaultInput('name');
    $model = (object) ['name' => 'model-value'];

    $recipe = new InputComponentRecipe(
        inputValue: fn (InputInterface $resolvedInput, array $values, ?object $resolvedModel): string => implode('|', [
            $resolvedInput->getName(),
            $values['other'] ?? 'none',
            $resolvedModel?->name ?? 'none',
        ]),
    );

    $manager = (new DefaultValueManager)
        ->setValues(['other' => 'other-value'])
        ->setModel($model);

    expect($manager->resolve($input, $recipe))->toBe('name|other-value|model-value');
});

test('the default value manager falls back to the model', function (): void {
    $input = new DefaultInput('name');
    $recipe = new InputComponentRecipe;
    $model = (object) ['name' => 'model-value'];

    $manager = (new DefaultValueManager)->setModel($model);

    expect($manager->resolve($input, $recipe))->toBe('model-value');
});

test('the default value manager returns null when nothing resolves', function (): void {
    $input = new DefaultInput('name');

    expect((new DefaultValueManager)->resolve($input, new InputComponentRecipe))->toBeNull();
});

test('the default value manager can ignore the recipe value', function (): void {
    $input = new DefaultInput('name');
    $recipe = new InputComponentRecipe(inputValue: 'recipe-value');
    $model = (object) ['name' => 'model-value'];

    $manager = (new DefaultValueManager)->setModel($model);

    expect($manager->resolve($input, $recipe, true))->toBe('model-value');
});

test('the default value manager keeps the values array when ignoring the recipe value', function (): void {
    $input = new DefaultInput('name');
    $recipe = new InputComponentRecipe(inputValue: 'recipe-value');

    $manager = (new DefaultValueManager)->setValues(['name' => 'array-value']);

    expect($manager->resolve($input, $recipe, true))->toBe('array-value');
});

test('the default value manager preserves non-string values', function (): void {
    $input = new DefaultInput('name');
    $recipe = new InputComponentRecipe;
    $stringable = new class implements Stringable
    {
        public function __toString(): string
        {
            return 'stringable-value';
        }
    };

    expect((new DefaultValueManager)->setValues(['name' => 42])->resolve($input, $recipe))->toBe(42)
        ->and((new DefaultValueManager)->setValues(['name' => ['a', 'b']])->resolve($input, $recipe))->toBe(['a', 'b'])
        ->and((new DefaultValueManager)->setValues(['name' => $stringable])->resolve($input, $recipe))->toBe($stringable);
});

test('the default error manager prioritizes the recipe error', function (): void {
    $input = new DefaultInput('name');
    $recipe = new InputComponentRecipe(inputError: 'recipe-error');

    $manager = (new DefaultErrorManager)->setErrors(['name' => 'array-error']);

    expect($manager->resolve($input, $recipe))->toBe('recipe-error');
});

test('the default error manager falls back to the errors array', function (): void {
    $input = new DefaultInput('name');
    $recipe = new InputComponentRecipe;

    $manager = (new DefaultErrorManager)->setErrors(['name' => 'array-error']);

    expect($manager->resolve($input, $recipe))->toBe('array-error');
});

test('the default error manager uses the last error from an error array', function (): void {
    $input = new DefaultInput('name');
    $recipe = new InputComponentRecipe;

    $manager = (new DefaultErrorManager)->setErrors([
        'name' => ['first-error', 'second-error', 'last-error'],
    ]);

    expect($manager->resolve($input, $recipe))->toBe('last-error');
});

test('the default error manager resolves recipe closures with the input and errors', function (): void {
    $input = new DefaultInput('name');
    $recipe = new InputComponentRecipe(
        inputError: fn (InputInterface $resolvedInput, array $errors): string => $resolvedInput->getName().'|'.$errors['name'],
    );

    $manager = (new DefaultErrorManager)->setErrors(['name' => 'array-error']);

    expect($manager->resolve($input, $recipe))->toBe('name|array-error');
});

test('the default error manager returns null when nothing resolves', function (): void {
    $input = new DefaultInput('name');

    expect((new DefaultErrorManager)->resolve($input, new InputComponentRecipe))->toBeNull()
        ->and((new DefaultErrorManager)->setErrors(['name' => []])->resolve($input, new InputComponentRecipe))->toBeNull();
});
