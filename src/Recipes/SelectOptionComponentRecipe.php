<?php

declare(strict_types=1);

namespace Juaniquillo\InputComponentAction\Recipes;

use Juaniquillo\BackendComponents\Enums\ComponentEnum;
use Juaniquillo\InputComponentAction\Bags\DefaultComponentBag;
use Juaniquillo\InputComponentAction\Bags\DefaultDisableBag;
use Juaniquillo\InputComponentAction\Groups\SoleInputGroup;

final class SelectOptionComponentRecipe extends InputComponentRecipe
{
    protected function configure(): void
    {
        if ($this->getInputGroup() === null) {
            $this->setInputGroup(new SoleInputGroup);
        }

        if ($this->getComponentBag() === null) {
            $this->setComponentBag(
                (new DefaultComponentBag)->setInputType(ComponentEnum::OPTION),
            );
        }

        if ($this->getDisableBag() === null) {
            $this->setDisableBag(
                (new DefaultDisableBag)
                    ->setDisableWrapper()
                    ->setDisableDefaultNameAttribute(),
            );
        }

        $this->setUseParentValue(true)
            ->setSelectable(true)
            ->setLabelAsInputContent(true);
    }
}
