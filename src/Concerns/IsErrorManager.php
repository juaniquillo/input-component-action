<?php

namespace Concerns;

trait IsErrorManager
{
    private array $errors = [];

    public function setErrors(array $errors): static
    {
        $this->errors = $errors;

        return $this;
    }

}
