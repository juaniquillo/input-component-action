<?php

declare(strict_types=1);

namespace Juaniquillo\InputComponentAction\Groups;

use Juaniquillo\BackendComponents\Contracts\BackendComponent;
use Juaniquillo\BackendComponents\Contracts\ContentComponent;
use Juaniquillo\InputComponentAction\Concerns\HasError;
use Juaniquillo\InputComponentAction\Concerns\HasHelpText;
use Juaniquillo\InputComponentAction\Concerns\HasLabel;
use Juaniquillo\InputComponentAction\Concerns\HasWrapper;
use Juaniquillo\InputComponentAction\Concerns\IsInputGroup;
use Juaniquillo\InputComponentAction\Contracts\InputGroup;
use Juaniquillo\InputComponentAction\Utilities\Support;

final class LabelHelpTextInputErrorGroup implements InputGroup
{
    use HasError,
        HasHelpText,
        HasLabel,
        HasWrapper,
        IsInputGroup;

    public function getGroup(): BackendComponent|ContentComponent
    {
        $wrapper = $this->getWrapperComponent() ?? Support::getCollectionWrapper();
        $label = $this->getLabelComponent();
        $helpText = $this->getHelpTextComponent();
        $input = $this->getInputComponent();
        $error = $this->getErrorComponent();

        $components = [];

        if ($label) {
            $components['label'] = $label;
        }

        if ($helpText) {
            $components['helpText'] = $helpText;
        }

        $components['input'] = $input;

        if ($error) {
            $components['error'] = $error;
        }

        return $wrapper->setContents($components);
    }
}
