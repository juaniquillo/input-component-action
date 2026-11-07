<?php

declare(strict_types=1);

namespace Juaniquillo\InputComponentAction\Managers;

use Closure;
use Juaniquillo\CrudAssistant\Contracts\InputInterface;
use Juaniquillo\InputComponentAction\Concerns\IsErrorManager;
use Juaniquillo\InputComponentAction\Contracts\ErrorManager;
use Juaniquillo\InputComponentAction\Contracts\InputComponentRecipeInterface;

final class DefaultErrorManager implements ErrorManager
{
    use IsErrorManager;

    public function resolve(InputInterface $input, InputComponentRecipeInterface $recipe): ?string
    {

        $errors = $this->errors;

        $name = $input->getName();

        $recipeError = $recipe->getInputError();
        $errorDefault = $errors[$name] ?? null;
        $error = null;

        if ($recipeError instanceof Closure) {
            $error = $recipeError($input, $errors);
        } else {
            $error = $recipeError;
        }

        /**
         * If multiple errors, the latest one wins.
         */
        if (is_array($errorDefault)) {
            $errorDefault = $errorDefault === []
                ? null
                : $errorDefault[array_key_last($errorDefault)];
        }

        return $error ?? $errorDefault ?? null;
    }
}
