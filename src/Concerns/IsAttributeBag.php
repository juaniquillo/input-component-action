<?php

declare(strict_types=1);

namespace Juaniquillo\InputComponentAction\Concerns;

use Closure;

trait IsAttributeBag
{
    /** @var Closure|array<string, int|string|null>|null */
    private Closure|array|null $inputAttributes = null;

    /** @var Closure|array<string, int|string|null>|null */
    private Closure|array|null $wrapperAttributes = null;

    /** @var Closure|array<string, int|string|null>|null */
    private Closure|array|null $labelAttributes = null;

    /** @var Closure|array<string, int|string|null>|null */
    private Closure|array|null $errorAttributes = null;

    /** @var Closure|array<string, int|string|null>|null */
    private Closure|array|null $helpTextAttributes = null;

    /** @param Closure|array<string, int|string|null> $inputAttributes */
    public function setInputAttributes(Closure|array $inputAttributes): static
    {
        $this->inputAttributes = $inputAttributes;

        return $this;
    }

    /** @return Closure|array<string, int|string|null>|null */
    public function getInputAttributes(): Closure|array|null
    {
        return $this->inputAttributes;
    }

    /** @param Closure|array<string, int|string|null> $wrapperAttributes */
    public function setWrapperAttributes(Closure|array $wrapperAttributes): static
    {
        $this->wrapperAttributes = $wrapperAttributes;

        return $this;
    }

    /** @return Closure|array<string, int|string|null>|null */
    public function getWrapperAttributes(): Closure|array|null
    {
        return $this->wrapperAttributes;
    }

    /** @param Closure|array<string, int|string|null> $labelAttributes */
    public function setLabelAttributes(Closure|array $labelAttributes): static
    {
        $this->labelAttributes = $labelAttributes;

        return $this;
    }

    /** @return Closure|array<string, int|string|null>|null */
    public function getLabelAttributes(): Closure|array|null
    {
        return $this->labelAttributes;
    }

    /** @param Closure|array<string, int|string|null> $errorAttributes */
    public function setErrorAttributes(Closure|array $errorAttributes): static
    {
        $this->errorAttributes = $errorAttributes;

        return $this;
    }

    /** @return Closure|array<string, int|string|null>|null */
    public function getErrorAttributes(): Closure|array|null
    {
        return $this->errorAttributes;
    }

    /** @param Closure|array<string, int|string|null> $helpTextAttributes */
    public function setHelpTextAttributes(Closure|array $helpTextAttributes): static
    {
        $this->helpTextAttributes = $helpTextAttributes;

        return $this;
    }

    /** @return Closure|array<string, int|string|null>|null */
    public function getHelpTextAttributes(): Closure|array|null
    {
        return $this->helpTextAttributes;
    }
}
