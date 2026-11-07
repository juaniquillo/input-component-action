<?php

declare(strict_types=1);

namespace Juaniquillo\InputComponentAction\Contracts;

use Juaniquillo\BackendComponents\Contracts\BackendComponent;
use Juaniquillo\BackendComponents\Contracts\ContentComponent;
use Juaniquillo\InputComponentAction\Groups\GroupContext;

interface InputGroup
{
    public function inject(GroupContext $context): static;

    public function getGroup(): BackendComponent|ContentComponent;
}
