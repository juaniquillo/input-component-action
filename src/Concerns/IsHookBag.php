<?php

declare(strict_types=1);

namespace Juaniquillo\InputComponentAction\Concerns;

use Closure;

trait IsHookBag
{
    private ?Closure $inputHook = null;

    private ?Closure $wrapperHook = null;

    private ?Closure $labelHook = null;

    private ?Closure $errorHook = null;

    private ?Closure $helpTextHook = null;

    public function setInputHook(Closure $inputHook): static
    {
        $this->inputHook = $inputHook;

        return $this;
    }

    public function getInputHook(): ?Closure
    {
        return $this->inputHook;
    }

    public function setWrapperHook(Closure $wrapperHook): static
    {
        $this->wrapperHook = $wrapperHook;

        return $this;
    }

    public function getWrapperHook(): ?Closure
    {
        return $this->wrapperHook;
    }

    public function setLabelHook(Closure $labelHook): static
    {
        $this->labelHook = $labelHook;

        return $this;
    }

    public function getLabelHook(): ?Closure
    {
        return $this->labelHook;
    }

    public function setErrorHook(Closure $errorHook): static
    {
        $this->errorHook = $errorHook;

        return $this;
    }

    public function getErrorHook(): ?Closure
    {
        return $this->errorHook;
    }

    public function setHelpTextHook(Closure $helpTextHook): static
    {
        $this->helpTextHook = $helpTextHook;

        return $this;
    }

    public function getHelpTextHook(): ?Closure
    {
        return $this->helpTextHook;
    }
}
