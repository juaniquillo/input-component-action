<?php

declare(strict_types=1);

namespace Juaniquillo\InputComponentAction\Contracts;

use Juaniquillo\CrudAssistant\Contracts\InputInterface;
use Stringable;

interface ValueManager
{
     /** @param array<string|int, string|int|array<string|int|null>|null> $values */
    public function setValues(array $values): static;

    /** @return array<string|int, string|int|array<string|int|null>|null> */
    public function getValues(): array;

    public function setModel(object $model): static;

    public function getModel(): ?object;

    public function resolve(InputInterface $input, InputComponentRecipeInterface $recipe, bool $ignoreRecipeValue = false): Stringable|string|int|array|null;
}
