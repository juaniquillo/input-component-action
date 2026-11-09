<?php

declare(strict_types=1);

namespace Juaniquillo\InputComponentAction\Recipes;

use Juaniquillo\BackendComponents\Enums\ComponentEnum;

final class SelectOptionComponentRecipe extends ChoiceComponentRecipe
{
    protected function choiceType(): ComponentEnum
    {
        return ComponentEnum::OPTION;
    }

    protected function configure(): void
    {
        parent::configure();

        $this->setSelectable(true)
            ->setLabelAsInputContent(true);

        $this->disableWrapper();
        $this->disableDefaultName();
    }
}
