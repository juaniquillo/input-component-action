<?php

declare(strict_types=1);

namespace Juaniquillo\InputComponentAction\Managers;

use Concerns\IsValueManager;
use Juaniquillo\CrudAssistant\Contracts\InputInterface;
use Juaniquillo\InputComponentAction\Contracts\InputComponentRecipeInterface;
use Juaniquillo\InputComponentAction\Contracts\ValueManager;
use Juaniquillo\InputComponentAction\Utilities\Support;
use Stringable;

/**
 * Priorities:
 * 1 - In $values array
 * 2 - In $recipe inputValue
 * 3 - In $model property
 */
final class DefaultValueManager implements ValueManager
{
    use IsValueManager;
    
    public function resolve(InputInterface $input, InputComponentRecipeInterface $recipe, bool $ignoreRecipeValue = false): Stringable|string|int|array|null
    {
        $values = $this->values;
        $model = $this->model;

        $name = $input->getName();

        if (array_key_exists(key: $name, array: $values)) {
            return $values[$name];
        }

        $recipeValue = $recipe->getInputValue();
        $modelValue = null;

        $modelValue = $model->{$name} ?? null;

        $recipeValueProcessed = null;

        if (! $ignoreRecipeValue) {
            if (Support::isClosure($recipeValue)) {
                $recipeValueProcessed = $recipeValue($input, $values, $model);
            } else {
                $recipeValueProcessed = $recipeValue;
            }
        }

        return $recipeValueProcessed ?? $modelValue ?? null;
    }
}
