<?php

declare(strict_types=1);

namespace Juaniquillo\InputComponentAction\Recipes;

use Juaniquillo\BackendComponents\Enums\ComponentEnum;
use Juaniquillo\InputComponentAction\Bags\DefaultComponentBag;
use Juaniquillo\InputComponentAction\Bags\DefaultDisableBag;
use Juaniquillo\InputComponentAction\Contracts\DisableBag;
use Juaniquillo\InputComponentAction\Groups\SoleInputGroup;

/**
 * Shared defaults for inputs that act as a choice of a parent input.
 *
 * The defaults are only applied when the corresponding bag or group was not
 * supplied, so custom components, groups and disables stay composable.
 */
abstract class ChoiceComponentRecipe extends InputComponentRecipe
{
    abstract protected function choiceType(): ComponentEnum;

    protected function configure(): void
    {
        $this->ensureInputType();

        if ($this->getInputGroup() === null) {
            $this->setInputGroup(new SoleInputGroup)
                ->setLabelAsInputContent(true);

            $this->disableWrapper();
        }

        $this->setUseParentValue(true)
            ->setUseInputNameAsValue(true);
    }

    protected function ensureInputType(): void
    {
        $componentBag = $this->getComponentBag() ?? new DefaultComponentBag;

        if ($componentBag->getInputType() === null) {
            $componentBag->setInputType($this->choiceType());
        }

        $this->setComponentBag($componentBag);
    }

    protected function disableWrapper(): void
    {
        $this->disableBag()->setDisableWrapper();
    }

    protected function disableDefaultName(): void
    {
        $this->disableBag()->setDisableDefaultNameAttribute();
    }

    private function disableBag(): DisableBag
    {
        $disableBag = $this->getDisableBag() ?? new DefaultDisableBag;

        $this->setDisableBag($disableBag);

        return $disableBag;
    }
}
