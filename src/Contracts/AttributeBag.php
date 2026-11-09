<?php

declare(strict_types=1);

namespace Juaniquillo\InputComponentAction\Contracts;

use Closure;

interface AttributeBag
{
    /** @param Closure|array<string, int|string|null> $inputAttributes */
    public function setInputAttributes(Closure|array $inputAttributes): static;

    /** @return Closure|array<string, int|string|null>|null */
    public function getInputAttributes(): Closure|array|null;

    /** @param Closure|array<string, int|string|null> $wrapperAttributes */
    public function setWrapperAttributes(Closure|array $wrapperAttributes): static;

    /** @return Closure|array<string, int|string|null>|null */
    public function getWrapperAttributes(): Closure|array|null;

    /** @param Closure|array<string, int|string|null> $labelAttributes */
    public function setLabelAttributes(Closure|array $labelAttributes): static;

    /** @return Closure|array<string, int|string|null>|null */
    public function getLabelAttributes(): Closure|array|null;

    /** @param Closure|array<string, int|string|null> $errorAttributes */
    public function setErrorAttributes(Closure|array $errorAttributes): static;

    /** @return Closure|array<string, int|string|null>|null */
    public function getErrorAttributes(): Closure|array|null;

    /** @param Closure|array<string, int|string|null> $helpTextAttributes */
    public function setHelpTextAttributes(Closure|array $helpTextAttributes): static;

    /** @return Closure|array<string, int|string|null>|null */
    public function getHelpTextAttributes(): Closure|array|null;
}
