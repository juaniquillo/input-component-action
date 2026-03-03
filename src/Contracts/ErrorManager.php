<?php

declare(strict_types=1);

namespace Juaniquillo\InputComponentAction\Contracts;

use Juaniquillo\CrudAssistant\Contracts\InputInterface;
use Juaniquillo\InputComponentAction\Recipes\InputComponentRecipe;

interface ErrorManager
{
    public function setErrors(array $errors): static;

    public function resolve(InputInterface $input, InputComponentRecipe $recipe): ?string;
}
