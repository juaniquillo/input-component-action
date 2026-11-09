<?php

declare(strict_types=1);

namespace Juaniquillo\InputComponentAction\Contracts;

use Juaniquillo\CrudAssistant\Contracts\InputInterface;
use Stringable;

interface ValueManager
{
    /** @param array<string|int, string|int|bool|array<string|int|bool|null>|null> $values */
    public function setValues(array $values): static;

    /** @return array<string|int, string|int|bool|array<string|int|bool|null>|null> */
    public function getValues(): array;

    public function setModel(?object $model): static;

    public function getModel(): ?object;

    /** @return Stringable|string|int|bool|array<string|int|bool|null>|null */
    public function resolve(InputInterface $input, InputComponentRecipeInterface $recipe, bool $ignoreRecipeValue = false): Stringable|string|int|bool|array|null;
}
