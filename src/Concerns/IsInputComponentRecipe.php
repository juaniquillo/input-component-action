<?php

declare(strict_types=1);

namespace Juaniquillo\InputComponentAction\Concerns;

use Closure;
use Juaniquillo\BaseBackendComponent\Contracts\ThemeManager;
use Juaniquillo\InputComponentAction\Contracts\AttributeBag;
use Juaniquillo\InputComponentAction\Contracts\ComponentBag;
use Juaniquillo\InputComponentAction\Contracts\DisableBag;
use Juaniquillo\InputComponentAction\Contracts\ErrorManager;
use Juaniquillo\InputComponentAction\Contracts\HookBag;
use Juaniquillo\InputComponentAction\Contracts\InputGroup;
use Juaniquillo\InputComponentAction\Contracts\ThemeBag;
use Juaniquillo\InputComponentAction\Contracts\ValueManager;

trait IsInputComponentRecipe
{
    private ?InputGroup $inputGroup = null;

    private ?ThemeManager $themeManager = null;

    private ?ComponentBag $componentBag = null;

    private ?AttributeBag $attributeBag = null;

    private ?ThemeBag $themeBag = null;

    private ?HookBag $hookBag = null;

    private ?ValueManager $valueBag = null;

    private ?ErrorManager $errorBag = null;

    private ?DisableBag $disableBag = null;

    private string|int|Closure|null $inputValue = null;

    private bool $useParentValue = false;

    private bool $useParentName = false;

    private bool $useInputNameAsValue = false;

    private string|Closure|null $inputError = null;

    private string|Closure|null $label = null;

    private bool $labelAsInputContent = false;

    private bool $emptyLabel = false;

    private bool $valueAsInputContent = false;

    private string|Closure|null $helpText = null;

    /**
     * Select menu, checkbox of radiobox
     */
    private bool $checkable = false;

    private bool $selectable = false;

    public function getInputGroup(): ?InputGroup
    {
        return $this->inputGroup;
    }

    public function setInputGroup(?InputGroup $inputGroup): self
    {
        $this->inputGroup = $inputGroup;

        return $this;
    }

    public function getThemeManager(): ?ThemeManager
    {
        return $this->themeManager;
    }

    public function setThemeManager(?ThemeManager $themeManager): self
    {
        $this->themeManager = $themeManager;

        return $this;
    }

    public function getComponentBag(): ?ComponentBag
    {
        return $this->componentBag;
    }

    public function setComponentBag(?ComponentBag $componentBag): self
    {
        $this->componentBag = $componentBag;

        return $this;
    }

    public function getAttributeBag(): ?AttributeBag
    {
        return $this->attributeBag;
    }

    public function setAttributeBag(?AttributeBag $attributeBag): self
    {
        $this->attributeBag = $attributeBag;

        return $this;
    }

    public function getThemeBag(): ?ThemeBag
    {
        return $this->themeBag;
    }

    public function setThemeBag(?ThemeBag $themeBag): self
    {
        $this->themeBag = $themeBag;

        return $this;
    }

    public function getHookBag(): ?HookBag
    {
        return $this->hookBag;
    }

    public function setHookBag(?HookBag $hookBag): self
    {
        $this->hookBag = $hookBag;

        return $this;
    }

    public function getValueBag(): ?ValueManager
    {
        return $this->valueBag;
    }

    public function setValueBag(?ValueManager $valueBag): self
    {
        $this->valueBag = $valueBag;

        return $this;
    }

    public function getErrorBag(): ?ErrorManager
    {
        return $this->errorBag;
    }

    public function setErrorBag(?ErrorManager $errorBag): self
    {
        $this->errorBag = $errorBag;

        return $this;
    }

    public function getInputValue(): string|int|Closure|null
    {
        return $this->inputValue;
    }

    public function setInputValue(string|int|Closure|null $inputValue): self
    {
        $this->inputValue = $inputValue;

        return $this;
    }

    public function useParentValue(): bool
    {
        return $this->useParentValue;
    }

    public function setUseParentValue(bool $useParentValue): self
    {
        $this->useParentValue = $useParentValue;

        return $this;
    }

    public function useParentName(): bool
    {
        return $this->useParentName;
    }

    public function setUseParentName(bool $useParentName): self
    {
        $this->useParentName = $useParentName;

        return $this;
    }

    public function useInputNameAsValue(): bool
    {
        return $this->useInputNameAsValue;
    }

    public function setUseInputNameAsValue(bool $useInputNameAsValue): self
    {
        $this->useInputNameAsValue = $useInputNameAsValue;

        return $this;
    }

    public function getInputError(): string|Closure|null
    {
        return $this->inputError;
    }

    public function setInputError(string|Closure|null $inputError): self
    {
        $this->inputError = $inputError;

        return $this;
    }

    public function getLabel(): string|Closure|null
    {
        return $this->label;
    }

    public function setLabel(string|Closure|null $label): self
    {
        $this->label = $label;

        return $this;
    }

    public function labelAsInputContent(): bool
    {
        return $this->labelAsInputContent;
    }

    public function setLabelAsInputContent(bool $labelAsInputContent): self
    {
        $this->labelAsInputContent = $labelAsInputContent;

        return $this;
    }

    public function isEmptyLabel(): bool
    {
        return $this->emptyLabel;
    }

    public function setEmptyLabel(bool $emptyLabel): self
    {
        $this->emptyLabel = $emptyLabel;

        return $this;
    }

    public function valueAsInputContent(): bool
    {
        return $this->valueAsInputContent;
    }

    public function setValueAsInputContent(bool $valueAsInputContent): self
    {
        $this->valueAsInputContent = $valueAsInputContent;

        return $this;
    }

    public function getHelpText(): string|Closure|null
    {
        return $this->helpText;
    }

    public function setHelpText(string|Closure|null $helpText): self
    {
        $this->helpText = $helpText;

        return $this;
    }

    public function getDisableBag(): ?DisableBag
    {
        return $this->disableBag;
    }

    public function setDisableBag(?DisableBag $disableBag): self
    {
        $this->disableBag = $disableBag;

        return $this;
    }

    public function isCheckable(): bool
    {
        return $this->checkable;
    }

    public function setCheckable(bool $checkable): self
    {
        $this->checkable = $checkable;

        return $this;
    }

    public function isSelectable(): bool
    {
        return $this->selectable;
    }

    public function setSelectable(bool $selectable): self
    {
        $this->selectable = $selectable;

        return $this;
    }
}
