<?php

declare(strict_types=1);

namespace Juaniquillo\InputComponentAction\Contracts;

use BackedEnum;
use Closure;

interface ComponentBag
{
    public function setInputComponent(Closure|string $inputComponent): static;

    public function getInputComponent(): Closure|string|null;

    public function setInputType(string|BackedEnum $inputType): static;

    public function getInputType(): string|BackedEnum|null;

    public function setWrapperComponent(Closure|string $wrapperComponent): static;

    public function getWrapperComponent(): Closure|string|null;

    public function setWrapperType(string|BackedEnum $wrapperType): static;

    public function getWrapperType(): string|BackedEnum|null;

    public function setLabelComponent(Closure|string $labelComponent): static;

    public function getLabelComponent(): Closure|string|null;

    public function setLabelType(string|BackedEnum $labelType): static;

    public function getLabelType(): string|BackedEnum|null;

    public function setErrorComponent(Closure|string $errorComponent): static;

    public function getErrorComponent(): Closure|string|null;

    public function setErrorType(string|BackedEnum $errorType): static;

    public function getErrorType(): string|BackedEnum|null;

    public function setHelpTextComponent(Closure|string $helpTextComponent): static;

    public function getHelpTextComponent(): Closure|string|null;

    public function setHelpTextType(string|BackedEnum $helpTextType): static;

    public function getHelpTextType(): string|BackedEnum|null;
}
