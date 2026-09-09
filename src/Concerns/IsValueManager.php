<?php

namespace Concerns;

trait IsValueManager
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

    public function getValues(): array
    {
        return $this->values;
    }

    public function getModel(): ?object
    {
        return $this->model;
    }

}
