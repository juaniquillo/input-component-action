<?php

declare(strict_types=1);

namespace Juaniquillo\InputComponentAction\Contracts;

use Juaniquillo\CrudAssistant\Contracts\InputInterface;

interface ValueManager
{
    public function setValues(array $values): static;

    public function setModel(object $model): static;

    public function resolve(InputInterface $input, InputComponentRecipeInterface $recipe, bool $ignoreRecipeValue = false): string|int|array|null;
}
