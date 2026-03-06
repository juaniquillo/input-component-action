<?php

declare(strict_types=1);

namespace Juaniquillo\InputComponentAction\Managers;

use Juaniquillo\CrudAssistant\Contracts\InputInterface;
use Juaniquillo\InputComponentAction\Contracts\ValueManager;
use Juaniquillo\InputComponentAction\Recipes\InputComponentRecipe;
use Juaniquillo\InputComponentAction\Utilities\Support;

/**
 * Priorities:
 * 1 - In $values array
 * 2 - In $recipe inputValue
 * 3 - In $model property
 */
final class DefaultValueManager implements ValueManager
{
    private array $values = [];

    private ?object $model = null;

    public function setValues(array $values): static
    {
        $this->values = $values;

        return $this;
    }

    public function setModel(?object $model): static
    {
        $this->model = $model;

        return $this;
    }

    public function resolve(InputInterface $input, InputComponentRecipe $recipe, bool $ignoreRecipeValue = false): string|int|array|null
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
