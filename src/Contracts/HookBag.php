<?php

declare(strict_types=1);

namespace Juaniquillo\InputComponentAction\Contracts;

use Closure;

interface HookBag
{
    public function setInputHook(Closure $inputHook): static;

    public function getInputHook(): ?Closure;

    public function setWrapperHook(Closure $wrapperHook): static;

    public function getWrapperHook(): ?Closure;

    public function setLabelHook(Closure $labelHook): static;

    public function getLabelHook(): ?Closure;

    public function setErrorHook(Closure $errorHook): static;

    public function getErrorHook(): ?Closure;

    public function setHelpTextHook(Closure $helpTextHook): static;

    public function getHelpTextHook(): ?Closure;
}
