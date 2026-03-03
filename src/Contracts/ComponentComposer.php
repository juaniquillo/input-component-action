<?php

declare(strict_types=1);

namespace Juaniquillo\InputComponentAction\Contracts;

use Juaniquillo\BackendComponents\Contracts\BackendComponent;
use Juaniquillo\BackendComponents\Contracts\ContentComponent;
use Juaniquillo\BackendComponents\Contracts\ThemeComponent;
use Juaniquillo\CrudAssistant\Contracts\InputInterface;

interface ComponentComposer
{
    public function setParent(InputInterface $parent): static;

    public function build(): BackendComponent|ContentComponent|ThemeComponent;
}
