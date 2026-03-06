<?php

declare(strict_types=1);

namespace Juaniquillo\InputComponentAction\Recipes;

use BackedEnum;
use Closure;
use Juaniquillo\BackendComponents\Contracts\ThemeManager;
use Juaniquillo\CrudAssistant\Concerns\IsRecipe;
use Juaniquillo\CrudAssistant\Contracts\RecipeInterface;
use Juaniquillo\InputComponentAction\Concerns\IsInputComponentRecipe;
use Juaniquillo\InputComponentAction\Contracts\AttributeBag;
use Juaniquillo\InputComponentAction\Contracts\ComponentBag;
use Juaniquillo\InputComponentAction\Contracts\ComposerDisableBag;
use Juaniquillo\InputComponentAction\Contracts\ErrorAttributes;
use Juaniquillo\InputComponentAction\Contracts\ErrorHook;
use Juaniquillo\InputComponentAction\Contracts\ErrorManager;
use Juaniquillo\InputComponentAction\Contracts\ErrorTheme;
use Juaniquillo\InputComponentAction\Contracts\HelpTextAttributes;
use Juaniquillo\InputComponentAction\Contracts\HelpTextHook;
use Juaniquillo\InputComponentAction\Contracts\HelpTextTheme;
use Juaniquillo\InputComponentAction\Contracts\HookBag;
use Juaniquillo\InputComponentAction\Contracts\InputGroup;
use Juaniquillo\InputComponentAction\Contracts\LabelAttributes;
use Juaniquillo\InputComponentAction\Contracts\LabelHook;
use Juaniquillo\InputComponentAction\Contracts\LabelTheme;
use Juaniquillo\InputComponentAction\Contracts\ThemeBag;
use Juaniquillo\InputComponentAction\Contracts\ValueManager;
use Juaniquillo\InputComponentAction\Contracts\WrapperAttributes;
use Juaniquillo\InputComponentAction\Contracts\WrapperHook;
use Juaniquillo\InputComponentAction\Contracts\WrapperTheme;
use Juaniquillo\InputComponentAction\InputComponentAction;

final class InputComponentRecipe implements RecipeInterface
{
    use IsRecipe;
    use IsInputComponentRecipe;

    /** @var class-string */
    protected $action = InputComponentAction::class;

    public function __construct(
        ?InputGroup $inputGroup = null,
        ?ThemeManager $themeManager = null,
        ?ComponentBag $componentBag = null,
        AttributeBag|WrapperAttributes|LabelAttributes|ErrorAttributes|HelpTextAttributes|null $attributeBag = null,
        ThemeBag|WrapperTheme|LabelTheme|ErrorTheme|HelpTextTheme|null $themeBag = null,
        HookBag|WrapperHook|LabelHook|ErrorHook|HelpTextHook|null $hookBag = null,
        ?ValueManager $valueBag = null,
        ?ErrorManager $errorBag = null,
        ?ComposerDisableBag $disableBag = null,
        string|int|Closure|null $inputValue = null,
        bool $useParentValue = false,
        string|Closure|null $inputError = null,
        string|Closure|null $label = null,
        bool $labelAsInputContent = false,
        bool $emptyLabel = false,
        bool $valueAsInputContent = false,
        string|Closure|null $helpText = null,
        string|BackedEnum|null $wrapperType = null,
        string|BackedEnum|null $labelType = null,
        string|BackedEnum|null $inputType = null,
        string|BackedEnum|null $errorType = null,
        string|BackedEnum|null $helpTextType = null,
        bool $checkable = false,
        bool $selectable = false,
    ) {
        $this->inputGroup = $inputGroup;
        $this->themeManager = $themeManager;
        $this->componentBag = $componentBag;
        $this->attributeBag = $attributeBag;
        $this->themeBag = $themeBag;
        $this->hookBag = $hookBag;
        $this->valueBag = $valueBag;
        $this->errorBag = $errorBag;
        $this->disableBag = $disableBag;
        $this->inputValue = $inputValue;
        $this->useParentValue = $useParentValue;
        $this->inputError = $inputError;
        $this->label = $label;
        $this->labelAsInputContent = $labelAsInputContent;
        $this->emptyLabel = $emptyLabel;
        $this->valueAsInputContent = $valueAsInputContent;
        $this->helpText = $helpText;
        $this->wrapperType = $wrapperType;
        $this->labelType = $labelType;
        $this->inputType = $inputType;
        $this->errorType = $errorType;
        $this->helpTextType = $helpTextType;
        $this->checkable = $checkable;
        $this->selectable = $selectable;
    }
}
