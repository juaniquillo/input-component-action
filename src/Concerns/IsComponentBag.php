<?php

declare(strict_types=1);

namespace Juaniquillo\InputComponentAction\Concerns;

use BackedEnum;
use Closure;

trait IsComponentBag
{
    private Closure|string|null $inputComponent = null;

    private string|BackedEnum|null $inputType = null;

    private Closure|string|null $wrapperComponent = null;

    private string|BackedEnum|null $wrapperType = null;

    private Closure|string|null $labelComponent = null;

    private string|BackedEnum|null $labelType = null;

    private Closure|string|null $errorComponent = null;

    private string|BackedEnum|null $errorType = null;

    private Closure|string|null $helpTextComponent = null;

    private string|BackedEnum|null $helpTextType = null;

    public function setInputComponent(Closure|string $inputComponent): static
    {
        $this->inputComponent = $inputComponent;

        return $this;
    }

    public function getInputComponent(): Closure|string|null
    {
        return $this->inputComponent;
    }

    public function setInputType(string|BackedEnum $inputType): static
    {
        $this->inputType = $inputType;

        return $this;
    }

    public function getInputType(): string|BackedEnum|null
    {
        return $this->inputType;
    }

    public function setWrapperComponent(Closure|string $wrapperComponent): static
    {
        $this->wrapperComponent = $wrapperComponent;

        return $this;
    }

    public function getWrapperComponent(): Closure|string|null
    {
        return $this->wrapperComponent;
    }

    public function setWrapperType(string|BackedEnum $wrapperType): static
    {
        $this->wrapperType = $wrapperType;

        return $this;
    }

    public function getWrapperType(): string|BackedEnum|null
    {
        return $this->wrapperType;
    }

    public function setLabelComponent(Closure|string $labelComponent): static
    {
        $this->labelComponent = $labelComponent;

        return $this;
    }

    public function getLabelComponent(): Closure|string|null
    {
        return $this->labelComponent;
    }

    public function setLabelType(string|BackedEnum $labelType): static
    {
        $this->labelType = $labelType;

        return $this;
    }

    public function getLabelType(): string|BackedEnum|null
    {
        return $this->labelType;
    }

    public function setErrorComponent(Closure|string $errorComponent): static
    {
        $this->errorComponent = $errorComponent;

        return $this;
    }

    public function getErrorComponent(): Closure|string|null
    {
        return $this->errorComponent;
    }

    public function setErrorType(string|BackedEnum $errorType): static
    {
        $this->errorType = $errorType;

        return $this;
    }

    public function getErrorType(): string|BackedEnum|null
    {
        return $this->errorType;
    }

    public function setHelpTextComponent(Closure|string $helpTextComponent): static
    {
        $this->helpTextComponent = $helpTextComponent;

        return $this;
    }

    public function getHelpTextComponent(): Closure|string|null
    {
        return $this->helpTextComponent;
    }

    public function setHelpTextType(string|BackedEnum $helpTextType): static
    {
        $this->helpTextType = $helpTextType;

        return $this;
    }

    public function getHelpTextType(): string|BackedEnum|null
    {
        return $this->helpTextType;
    }
}
