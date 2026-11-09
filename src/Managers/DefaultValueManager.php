<?php

declare(strict_types=1);

namespace Juaniquillo\InputComponentAction\Managers;

use Closure;
use Juaniquillo\CrudAssistant\Contracts\InputInterface;
use Juaniquillo\InputComponentAction\Concerns\IsValueManager;
use Juaniquillo\InputComponentAction\Contracts\InputComponentRecipeInterface;
use Juaniquillo\InputComponentAction\Contracts\ValueManager;
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

    /** @return Stringable|string|int|array<string|int|null>|null */
    public function resolve(InputInterface $input, InputComponentRecipeInterface $recipe, bool $ignoreRecipeValue = false): Stringable|string|int|array|null
    {
        $name = $input->getName();

        if ($name === null) {
            return null;
        }

        if (array_key_exists(key: $name, array: $this->values)) {
            return $this->values[$name];
        }

        if (! $ignoreRecipeValue) {
            $recipeValue = $recipe->getInputValue();

            $recipeValue = $recipeValue instanceof Closure
                ? $recipeValue($input, $this->values, $this->model)
                : $recipeValue;

            if ($recipeValue !== null) {
                return $recipeValue;
            }
        }

        return $this->model->{$name} ?? null;
    }
}
