<?php

declare(strict_types=1);

namespace Juaniquillo\InputComponentAction\Contracts;

use BackedEnum;
use Closure;
use Juaniquillo\BackendComponents\Contracts\ThemeManager;

interface InputComponentRecipeInterface
{
    public static function make(): self;

    public function getInputGroup(): ?InputGroup;

    public function setInputGroup(?InputGroup $inputGroup): self;

    public function getThemeManager(): ?ThemeManager;

    public function setThemeManager(?ThemeManager $themeManager): self;

    public function getComponentBag(): ComponentBag|WrapperComponent|LabelComponent|ErrorComponent|HelpTextComponent|null;

    public function setComponentBag(ComponentBag|WrapperComponent|LabelComponent|ErrorComponent|HelpTextComponent|null $componentBag): self;

    public function getAttributeBag(): AttributeBag|WrapperAttributes|LabelAttributes|ErrorAttributes|HelpTextAttributes|null;

    public function setAttributeBag(AttributeBag|WrapperAttributes|LabelAttributes|ErrorAttributes|HelpTextAttributes|null $attributeBag): self;

    public function getThemeBag(): ThemeBag|WrapperTheme|LabelTheme|ErrorTheme|HelpTextTheme|null;

    public function setThemeBag(ThemeBag|WrapperTheme|LabelTheme|ErrorTheme|HelpTextTheme|null $themeBag): self;

    public function getHookBag(): HookBag|WrapperHook|LabelHook|ErrorHook|HelpTextHook|null;

    public function setHookBag(HookBag|WrapperHook|LabelHook|ErrorHook|HelpTextHook|null $hookBag): self;

    public function getValueBag(): ?ValueManager;

    public function setValueBag(?ValueManager $valueBag): self;

    public function getErrorBag(): ?ErrorManager;

    public function setErrorBag(?ErrorManager $errorBag): self;

    public function getInputValue(): string|int|Closure|null;

    public function setInputValue(string|int|Closure|null $inputValue): self;

    public function useParentValue(): bool;

    public function setUseParentValue(bool $useParentValue): self;

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

    public function getDisableBag(): DisableBag|WrapperDisable|LabelDisable|ErrorDisable|HelpTextDisable|InputDisable|null;

    public function setDisableBag(DisableBag|WrapperDisable|LabelDisable|ErrorDisable|HelpTextDisable|InputDisable|null $disableBag): self;

    public function getWrapperType(): string|BackedEnum|null;

    public function setWrapperType(string|BackedEnum|null $wrapperType): self;

    public function getLabelType(): string|BackedEnum|null;

    public function setLabelType(string|BackedEnum|null $labelType): self;

    public function getInputType(): string|BackedEnum|null;

    public function setInputType(string|BackedEnum|null $inputType): self;

    public function getErrorType(): string|BackedEnum|null;

    public function setErrorType(string|BackedEnum|null $errorType): self;

    public function getHelpTextType(): string|BackedEnum|null;

    public function setHelpTextType(string|BackedEnum|null $helpTextType): self;

    public function isCheckable(): bool;

    public function setCheckable(bool $checkable): self;

    public function isSelectable(): bool;

    public function setSelectable(bool $selectable): self;
}
