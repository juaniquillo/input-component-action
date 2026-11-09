<?php

declare(strict_types=1);

namespace Juaniquillo\InputComponentAction\Recipes;

use Juaniquillo\BackendComponents\Enums\ComponentEnum;

final class CheckboxComponentRecipe extends ChoiceComponentRecipe
{
    protected function choiceType(): ComponentEnum
    {
        return ComponentEnum::CHECKBOX_INPUT;
    }

    protected function configure(): void
    {
        parent::configure();

        $this->setCheckable(true)
            ->setUseParentName(true);
    }
}
