<?php

declare(strict_types=1);

namespace Juaniquillo\InputComponentAction\Factories;

use Exception;
use Juaniquillo\BackendComponents\Contracts\BackendComponent;
use Juaniquillo\BackendComponents\Contracts\ContentComponent;
use Juaniquillo\InputComponentAction\Groups\GroupContext;
use Juaniquillo\InputComponentAction\Utilities\Support;

final class InputGroupFactory
{
    public static function init(GroupContext $context): BackendComponent&ContentComponent
    {
        $group = $context->recipe->getInputGroup() ?? Support::resolveInputGroup($context->defaultInputGroup);
        $component = $group->inject($context)->getGroup();

        if (! $component instanceof BackendComponent || ! $component instanceof ContentComponent) {
            throw new Exception('Input groups must return a renderable backend component.', 500);
        }

        return $component;
    }
}
