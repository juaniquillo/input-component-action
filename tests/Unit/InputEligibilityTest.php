<?php

declare(strict_types=1);

namespace Tests\Unit;

use Juaniquillo\CrudAssistant\Actions\FilterAction;
use Juaniquillo\CrudAssistant\CrudAssistant;
use Juaniquillo\CrudAssistant\Inputs\DefaultInput;
use Juaniquillo\CrudAssistant\Inputs\OptionInput;
use Juaniquillo\InputComponentAction\Bags\DefaultComponentBag;
use Juaniquillo\InputComponentAction\Groups\DefaultInputGroup;
use Juaniquillo\InputComponentAction\InputComponentAction;
use Juaniquillo\InputComponentAction\Managers\DefaultErrorManager;
use Juaniquillo\InputComponentAction\Managers\DefaultValueManager;
use Juaniquillo\InputComponentAction\Recipes\InputComponentRecipe;
use Juaniquillo\InputComponentAction\Resolvers\ChildInputResolver;
use Juaniquillo\InputComponentAction\Resolvers\InputEligibility;

function eligibility(): InputEligibility
{
    return new InputEligibility(InputComponentAction::getIdentifier());
}

function childResolver(InputEligibility $eligibility): ChildInputResolver
{
    return new ChildInputResolver(
        eligibility: $eligibility,
        values: new DefaultValueManager,
        errors: new DefaultErrorManager,
        componentBag: new DefaultComponentBag,
        defaultInputGroup: DefaultInputGroup::class,
        defaultThemeManager: null,
    );
}

test('it exposes the action identifier', function (): void {
    expect(eligibility()->getIdentifier())->toBe(InputComponentAction::class);
});

test('it resolves inputs without config', function (): void {
    expect(eligibility()->isResolvable(new DefaultInput('name')))->toBeTrue();
});

test('it does not resolve ignored inputs', function (): void {
    $input = new DefaultInput('name');
    $input->setRecipe((new InputComponentRecipe)->ignore());

    expect(eligibility()->isResolvable($input))->toBeFalse();
});

test('it does not resolve inputs scoped to another action', function (): void {
    $input = (new DefaultInput('name'))->onlyFor([FilterAction::class]);

    expect(eligibility()->isResolvable($input))->toBeFalse();
});

test('it resolves inputs scoped to this action', function (): void {
    $input = (new DefaultInput('name'))->onlyFor([InputComponentAction::class]);

    expect(eligibility()->isResolvable($input))->toBeTrue();
});

test('it detects resolvable sub elements', function (): void {
    $input = new DefaultInput('choice');
    $input->setSubElements(CrudAssistant::make([
        (new OptionInput('a', 'A'))->setRecipe(new InputComponentRecipe),
        (new OptionInput('b', 'B'))->setRecipe((new InputComponentRecipe)->ignore()),
    ]));

    $resolver = childResolver(eligibility());

    expect($resolver->hasResolvableSubElements($input))->toBeTrue()
        ->and($resolver->canResolve($input))->toBeTrue();
});

test('it detects inputs without resolvable sub elements', function (): void {
    $input = new DefaultInput('choice');
    $input->setSubElements(CrudAssistant::make([
        (new OptionInput('a', 'A'))->setRecipe((new InputComponentRecipe)->ignore()),
    ]));

    $resolver = childResolver(eligibility());

    expect($resolver->hasResolvableSubElements($input))->toBeFalse()
        ->and($resolver->resolveChildren($input))->toBeNull();
});

test('it reports no resolvable sub elements when there are none', function (): void {
    $resolver = childResolver(eligibility());

    expect($resolver->hasResolvableSubElements(new DefaultInput('choice')))->toBeFalse()
        ->and($resolver->resolveChildren(new DefaultInput('choice')))->toBeNull();
});
