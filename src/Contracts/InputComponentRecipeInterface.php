<?php

declare(strict_types=1);

namespace Juaniquillo\InputComponentAction\Contracts;

use Closure;
use Juaniquillo\BaseBackendComponent\Contracts\ThemeManager;

interface InputComponentRecipeInterface
{
    public function getInputGroup(): ?InputGroup;

    public function setInputGroup(?InputGroup $inputGroup): self;

    public function getThemeManager(): ?ThemeManager;

    public function setThemeManager(?ThemeManager $themeManager): self;

    public function getComponentBag(): ?ComponentBag;

    public function setComponentBag(?ComponentBag $componentBag): self;

    public function getAttributeBag(): ?AttributeBag;

    public function setAttributeBag(?AttributeBag $attributeBag): self;

    public function getThemeBag(): ?ThemeBag;

    public function setThemeBag(?ThemeBag $themeBag): self;

    public function getHookBag(): ?HookBag;

    public function setHookBag(?HookBag $hookBag): self;

    public function getValueBag(): ?ValueManager;

    public function setValueBag(?ValueManager $valueBag): self;

    public function getErrorBag(): ?ErrorManager;

    public function setErrorBag(?ErrorManager $errorBag): self;

    public function getInputValue(): string|int|Closure|null;

    public function setInputValue(string|int|Closure|null $inputValue): self;

    public function useParentValue(): bool;

    public function setUseParentValue(bool $useParentValue): self;

    public function useParentName(): bool;

    public function setUseParentName(bool $useParentName): self;

    public function useInputNameAsValue(): bool;

    public function setUseInputNameAsValue(bool $useInputNameAsValue): self;

    public function getInputError(): string|Closure|null;

    public function setInputError(string|Closure|null $inputError): self;

    public function getLabel(): string|Closure|null;

    public function setLabel(string|Closure|null $label): self;

    public function labelAsInputContent(): bool;

    public function setLabelAsInputContent(bool $labelAsInputContent): self;

    public function isEmptyLabel(): bool;

    public function setEmptyLabel(bool $emptyLabel): self;

    public function valueAsInputContent(): bool;

    public function setValueAsInputContent(bool $valueAsInputContent): self;

    public function getHelpText(): string|Closure|null;

    public function setHelpText(string|Closure|null $helpText): self;

    public function getDisableBag(): ?DisableBag;

    public function setDisableBag(?DisableBag $disableBag): self;

    public function isCheckable(): bool;

    public function setCheckable(bool $checkable): self;

    public function isSelectable(): bool;

    public function setSelectable(bool $selectable): self;
}
