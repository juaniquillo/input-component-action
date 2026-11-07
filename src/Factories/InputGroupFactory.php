<?php

declare(strict_types=1);

namespace Juaniquillo\InputComponentAction\Factories;

use Juaniquillo\BackendComponents\Contracts\BackendComponent;
use Juaniquillo\InputComponentAction\Groups\GroupContext;
use Juaniquillo\InputComponentAction\Utilities\Support;

final class InputGroupFactory
{
    public static function init(GroupContext $context): BackendComponent
    {
        $group = $context->recipe->getInputGroup() ?? Support::resolveInputGroup($context->defaultInputGroup);

        return $group->inject($context)->getGroup();
    }
}
