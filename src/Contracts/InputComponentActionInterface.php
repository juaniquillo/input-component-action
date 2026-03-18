<?php

declare(strict_types=1);

namespace Juaniquillo\InputComponentAction\Contracts;

use Closure;
use Juaniquillo\BackendComponents\Contracts\BackendComponent;
use Juaniquillo\BackendComponents\Contracts\ContentComponent;
use Juaniquillo\BackendComponents\Contracts\ThemeComponent;
use Juaniquillo\BackendComponents\Contracts\ThemeManager;
use Juaniquillo\CrudAssistant\Contracts\InputInterface;
use Juaniquillo\CrudAssistant\InputCollection;

interface InputComponentActionInterface
{
    public function setThemeManager(ThemeManager $defaultThemeManager): static;

    public function setDefaultInputGroup(string|Closure|null $defaultInputGroup): static;

    public function setDefaultThemeBag(ThemeBag|WrapperTheme|LabelTheme|ErrorTheme|HelpTextTheme $defaultThemeBag): static;

    public function setDefaultComponentBag(ComponentBag|WrapperComponent|LabelComponent|ErrorComponent|HelpTextComponent $defaultComponentBag): static;

    public function setModel(?object $model = null): static;

    public function setValueManager(ValueManager $valueBag): static;

    public function setErrorManager(ErrorManager $errorBag): static;

    public function resolveInputs(InputCollection|InputInterface|\IteratorAggregate $input): array|BackendComponent|ContentComponent;

    public function getInputGroup(InputInterface $input): BackendComponent;

    public function getWrapper(InputInterface $input): BackendComponent|ContentComponent|ThemeComponent;

    public function getValueManager(?InputComponentRecipeInterface $recipe): ValueManager;

    public function getErrorManager(?InputComponentRecipeInterface $recipe): ErrorManager;
}
