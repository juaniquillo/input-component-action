<?php

declare(strict_types=1);

namespace Juaniquillo\InputComponentAction\Groups;

use Juaniquillo\BackendComponents\Contracts\BackendComponent;
use Juaniquillo\BackendComponents\Contracts\ContentComponent;
use Juaniquillo\InputComponentAction\Concerns\HasError;
use Juaniquillo\InputComponentAction\Concerns\HasLabel;
use Juaniquillo\InputComponentAction\Concerns\HasWrapper;
use Juaniquillo\InputComponentAction\Concerns\IsInputGroup;
use Juaniquillo\InputComponentAction\Contracts\InputGroup;
use Juaniquillo\InputComponentAction\Utilities\Support;

final class InputLabelErrorGroup implements InputGroup
{
    use HasError,
        HasLabel,
        HasWrapper,
        IsInputGroup;

    public function getGroup(): BackendComponent|ContentComponent
    {
        $wrapper = $this->getWrapperComponent() ?? Support::getCollectionWrapper();
        $label = $this->getLabelComponent();
        $input = $this->getInputComponent();
        $error = $this->getErrorComponent();

        $components = [];

        $components['input'] = $input;

        if ($label) {
            $components['label'] = $label;
        }

        if ($error) {
            $components['error'] = $error;
        }

        return $wrapper->setContents($components);
    }
}
