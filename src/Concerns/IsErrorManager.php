<?php

declare(strict_types=1);

namespace Juaniquillo\InputComponentAction\Concerns;

trait IsErrorManager
{
    /** @var array<string, string|array<int, string>|null> */
    private array $errors = [];

    /** @param array<string, string|array<int, string>|null> $errors */
    public function setErrors(array $errors): static
    {
        $this->errors = $errors;

        return $this;
    }
}
