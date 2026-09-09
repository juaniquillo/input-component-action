<?php

declare(strict_types=1);

namespace Juaniquillo\InputComponentAction\Concerns;

trait IsErrorManager
{
    private array $errors = [];

    public function setErrors(array $errors): static
    {
        $this->errors = $errors;

        return $this;
    }
}
