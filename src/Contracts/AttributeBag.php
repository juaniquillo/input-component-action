<?php

declare(strict_types=1);

namespace Juaniquillo\InputComponentAction\Contracts;

use Closure;

interface AttributeBag
{
    public function setInputAttributes(Closure|array $inputAttributes): static;

    public function getInputAttributes(): Closure|array|null;

    public function setWrapperAttributes(Closure|array $wrapperAttributes): static;

    public function getWrapperAttributes(): Closure|array|null;

    public function setLabelAttributes(Closure|array $labelAttributes): static;

    public function getLabelAttributes(): Closure|array|null;

    public function setErrorAttributes(Closure|array $errorAttributes): static;

    public function getErrorAttributes(): Closure|array|null;

    public function setHelpTextAttributes(Closure|array $helpTextAttributes): static;

    public function getHelpTextAttributes(): Closure|array|null;
}
