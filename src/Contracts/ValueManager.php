<?php

declare(strict_types=1);

namespace Juaniquillo\InputComponentAction\Contracts;

use Juaniquillo\CrudAssistant\Contracts\InputInterface;
use Stringable;

interface ValueManager
{
    /** @param array<string|int, string|int|array<string|int|null>|null> $values */
    public function setValues(array $values): static;

    public function setModel(object $model): static;

    public function resolve(InputInterface $input, InputComponentRecipeInterface $recipe, bool $ignoreRecipeValue = false): Stringable|string|int|array|null;
}
