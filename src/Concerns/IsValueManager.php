<?php

declare(strict_types=1);

namespace Juaniquillo\InputComponentAction\Concerns;

trait IsValueManager
{
    /** @var array<string|int, string|int|array<string|int|null>|null> */
    private array $values = [];

    private ?object $model = null;

    /** @param array<string|int, string|int|array<string|int|null>|null> $values */
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

    /** @return array<string|int, string|int|array<string|int|null>|null> */
    public function getValues(): array
    {
        return $this->values;
    }

    public function getModel(): ?object
    {
        return $this->model;
    }
}
