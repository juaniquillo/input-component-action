<?php

declare(strict_types=1);

namespace Juaniquillo\InputComponentAction\Concerns;

use BackedEnum;
use Closure;
use Juaniquillo\BackendComponents\Contracts\ThemeManager;
use Juaniquillo\InputComponentAction\Contracts\AttributeBag;
use Juaniquillo\InputComponentAction\Contracts\ComponentBag;
use Juaniquillo\InputComponentAction\Contracts\DisableBag;
use Juaniquillo\InputComponentAction\Contracts\ErrorAttributes;
use Juaniquillo\InputComponentAction\Contracts\ErrorDisable;
use Juaniquillo\InputComponentAction\Contracts\ErrorHook;
use Juaniquillo\InputComponentAction\Contracts\ErrorManager;
use Juaniquillo\InputComponentAction\Contracts\ErrorTheme;
use Juaniquillo\InputComponentAction\Contracts\HelpTextAttributes;
use Juaniquillo\InputComponentAction\Contracts\HelpTextDisable;
use Juaniquillo\InputComponentAction\Contracts\HelpTextHook;
use Juaniquillo\InputComponentAction\Contracts\HelpTextTheme;
use Juaniquillo\InputComponentAction\Contracts\HookBag;
use Juaniquillo\InputComponentAction\Contracts\InputDisable;
use Juaniquillo\InputComponentAction\Contracts\InputGroup;
use Juaniquillo\InputComponentAction\Contracts\LabelAttributes;
use Juaniquillo\InputComponentAction\Contracts\LabelDisable;
use Juaniquillo\InputComponentAction\Contracts\LabelHook;
use Juaniquillo\InputComponentAction\Contracts\LabelTheme;
use Juaniquillo\InputComponentAction\Contracts\ThemeBag;
use Juaniquillo\InputComponentAction\Contracts\ValueManager;
use Juaniquillo\InputComponentAction\Contracts\WrapperAttributes;
use Juaniquillo\InputComponentAction\Contracts\WrapperDisable;
use Juaniquillo\InputComponentAction\Contracts\WrapperHook;
use Juaniquillo\InputComponentAction\Contracts\WrapperTheme;
use Juaniquillo\InputComponentAction\InputComponentAction;

trait IsInputComponentRecipe
{
    private ?InputGroup $inputGroup = null;

    private ?ThemeManager $themeManager = null;

    private ?ComponentBag $componentBag = null;

    private AttributeBag|WrapperAttributes|LabelAttributes|ErrorAttributes|HelpTextAttributes|null $attributeBag = null;

    private ThemeBag|WrapperTheme|LabelTheme|ErrorTheme|HelpTextTheme|null $themeBag = null;

    private HookBag|WrapperHook|LabelHook|ErrorHook|HelpTextHook|null $hookBag = null;

    private ?ValueManager $valueBag = null;

    private ?ErrorManager $errorBag = null;

    private ?DisableBag $disableBag = null;

    private string|int|Closure|null $inputValue = null;

    private bool $useParentValue = false;

    private string|Closure|null $inputError = null;

    private string|Closure|null $label = null;

    private bool $labelAsInputContent = false;

    private bool $emptyLabel = false;

    private bool $valueAsInputContent = false;

    private string|Closure|null $helpText = null;

    private string|BackedEnum|null $wrapperType = null;

    private string|BackedEnum|null $labelType = null;

    private string|BackedEnum|null $inputType = null;

    private string|BackedEnum|null $errorType = null;

    private string|BackedEnum|null $helpTextType = null;

    /**
     * Select menu, checkbox of radiobox
     */
    private bool $checkable = false;

    private bool $selectable = false;

    public static function make(): self
    {
        return new self();
    }

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

    public function getAttributeBag(): AttributeBag|WrapperAttributes|LabelAttributes|ErrorAttributes|HelpTextAttributes|null
    {
        return $this->attributeBag;
    }

    public function setAttributeBag(AttributeBag|WrapperAttributes|LabelAttributes|ErrorAttributes|HelpTextAttributes|null $attributeBag): self
    {
        $this->attributeBag = $attributeBag;

        return $this;
    }

    public function getThemeBag(): ThemeBag|WrapperTheme|LabelTheme|ErrorTheme|HelpTextTheme|null
    {
        return $this->themeBag;
    }

    public function setThemeBag(ThemeBag|WrapperTheme|LabelTheme|ErrorTheme|HelpTextTheme|null $themeBag): self
    {
        $this->themeBag = $themeBag;

        return $this;
    }

    public function getHookBag(): HookBag|WrapperHook|LabelHook|ErrorHook|HelpTextHook|null
    {
        return $this->hookBag;
    }

    public function setHookBag(HookBag|WrapperHook|LabelHook|ErrorHook|HelpTextHook|null $hookBag): self
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

    public function getDisableBag(): DisableBag|WrapperDisable|LabelDisable|ErrorDisable|HelpTextDisable|InputDisable|null
    {
        return $this->disableBag;
    }

    public function setDisableBag(DisableBag|WrapperDisable|LabelDisable|ErrorDisable|HelpTextDisable|InputDisable|null $disableBag): self
    {
        $this->disableBag = $disableBag;

        return $this;
    }

    public function getWrapperType(): string|BackedEnum|null
    {
        return $this->wrapperType;
    }

    public function setWrapperType(string|BackedEnum|null $wrapperType): self
    {
        $this->wrapperType = $wrapperType;

        return $this;
    }

    public function getLabelType(): string|BackedEnum|null
    {
        return $this->labelType;
    }

    public function setLabelType(string|BackedEnum|null $labelType): self
    {
        $this->labelType = $labelType;

        return $this;
    }

    public function getInputType(): string|BackedEnum|null
    {
        return $this->inputType;
    }

    public function setInputType(string|BackedEnum|null $inputType): self
    {
        $this->inputType = $inputType;

        return $this;
    }

    public function getErrorType(): string|BackedEnum|null
    {
        return $this->errorType;
    }

    public function setErrorType(string|BackedEnum|null $errorType): self
    {
        $this->errorType = $errorType;

        return $this;
    }

    public function getHelpTextType(): string|BackedEnum|null
    {
        return $this->helpTextType;
    }

    public function setHelpTextType(string|BackedEnum|null $helpTextType): self
    {
        $this->helpTextType = $helpTextType;

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
