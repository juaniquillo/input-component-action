<?php

declare(strict_types=1);

namespace Juaniquillo\InputComponentAction\Recipes;

use Closure;
use Juaniquillo\BackendComponents\Contracts\ThemeManager;
use Juaniquillo\CrudAssistant\Concerns\IsRecipe;
use Juaniquillo\CrudAssistant\Contracts\RecipeInterface;
use Juaniquillo\InputComponentAction\Concerns\IsInputComponentRecipe;
use Juaniquillo\InputComponentAction\Contracts\AttributeBag;
use Juaniquillo\InputComponentAction\Contracts\ComponentBag;
use Juaniquillo\InputComponentAction\Contracts\DisableBag;
use Juaniquillo\InputComponentAction\Contracts\ErrorManager;
use Juaniquillo\InputComponentAction\Contracts\HookBag;
use Juaniquillo\InputComponentAction\Contracts\InputComponentRecipeInterface;
use Juaniquillo\InputComponentAction\Contracts\InputGroup;
use Juaniquillo\InputComponentAction\Contracts\ThemeBag;
use Juaniquillo\InputComponentAction\Contracts\ValueManager;
use Juaniquillo\InputComponentAction\InputComponentAction;

class InputComponentRecipe implements InputComponentRecipeInterface, RecipeInterface
{
    use IsInputComponentRecipe;
    use IsRecipe;

    public function __construct(
        ?InputGroup $inputGroup = null,
        ?ThemeManager $themeManager = null,
        ?ComponentBag $componentBag = null,
        ?AttributeBag $attributeBag = null,
        ?ThemeBag $themeBag = null,
        ?HookBag $hookBag = null,
        ?ValueManager $valueBag = null,
        ?ErrorManager $errorBag = null,
        ?DisableBag $disableBag = null,
        string|int|Closure|null $inputValue = null,
        string|Closure|null $inputError = null,
        string|Closure|null $label = null,
        bool $useParentValue = false,
        bool $labelAsInputContent = false,
        bool $emptyLabel = false,
        bool $valueAsInputContent = false,
        string|Closure|null $helpText = null,
        bool $checkable = false,
        bool $selectable = false,
        bool $useParentName = false,
        bool $useInputNameAsValue = false,
    ) {
        $this->action = InputComponentAction::class;
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
        $this->checkable = $checkable;
        $this->selectable = $selectable;
        $this->useParentName = $useParentName;
        $this->useInputNameAsValue = $useInputNameAsValue;

        $this->configure();
    }

    protected function configure(): void {}
}
