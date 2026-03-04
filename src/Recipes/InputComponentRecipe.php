<?php

declare(strict_types=1);

namespace Juaniquillo\InputComponentAction\Recipes;

use Closure;
use Juaniquillo\BackendComponents\Contracts\ThemeManager;
use Juaniquillo\BackendComponents\Enums\ComponentEnum;
use Juaniquillo\CrudAssistant\Concerns\IsRecipe;
use Juaniquillo\CrudAssistant\Contracts\RecipeInterface;
use Juaniquillo\InputComponentAction\Contracts\AttributeBag;
use Juaniquillo\InputComponentAction\Contracts\ComponentBag;
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

    /** @var class-string */
    protected $action = InputComponentAction::class;

    public function __construct(

        public readonly ?InputGroup $inputGroup = null,

        public readonly ?ThemeManager $themeManager = null,

        public readonly ?ComponentBag $componentBag = null,
        public readonly AttributeBag|WrapperAttributes|LabelAttributes|ErrorAttributes|HelpTextAttributes|null $attributeBag = null,
        public readonly ThemeBag|WrapperTheme|LabelTheme|ErrorTheme|HelpTextTheme|null $themeBag = null,
        public readonly HookBag|WrapperHook|LabelHook|ErrorHook|HelpTextHook|null $hookBag = null,

        public readonly ?ValueManager $valueBag = null,
        public readonly ?ErrorManager $errorBag = null,

        public readonly string|int|Closure|null $inputValue = null,
        public readonly bool $useParentValue = false,
        public readonly string|Closure|null $inputError = null,

        public readonly string|Closure|null $label = null,
        public readonly bool $labelAsInputContent = false,
        public readonly bool $emptyLabel = false,
        public readonly bool $valueAsInputContent = false,
        public readonly string|Closure|null $helpText = null,

        public readonly bool $disableInputValue = false,
        public readonly bool $disableDefaultNameAttribute = false,
        public readonly bool $disableDefaultIdAttribute = false,
        public readonly bool $disableDefaultForAttribute = false,

        public readonly bool $disableWrapper = false,
        public readonly bool $disableLabel = false,
        public readonly bool $disableError = false,
        public readonly bool $disableHelpText = false,

        public readonly string|ComponentEnum|null $wrapperType = null,
        public readonly string|ComponentEnum|null $labelType = null,
        public readonly string|ComponentEnum|null $inputType = null,
        public readonly string|ComponentEnum|null $errorType = null,
        public readonly string|ComponentEnum|null $helpTextType = null,

        /**
         * Select menu, checkbox of radiobox
         */
        public readonly bool $checkable = false,
        public readonly bool $selectable = false,

    ) {}
}
