<?php

declare(strict_types=1);

namespace Juaniquillo\InputComponentAction\Groups;

use Exception;
use Juaniquillo\BaseBackendComponent\Contracts\BackendComponent;
use Juaniquillo\BaseBackendComponent\Contracts\ContentComponent;
use Juaniquillo\InputComponentAction\Concerns\HasError;
use Juaniquillo\InputComponentAction\Concerns\HasHelpText;
use Juaniquillo\InputComponentAction\Concerns\HasLabel;
use Juaniquillo\InputComponentAction\Concerns\HasWrapper;
use Juaniquillo\InputComponentAction\Concerns\IsInputGroup;
use Juaniquillo\InputComponentAction\Contracts\InputGroup;
use Juaniquillo\InputComponentAction\Enums\Slot;
use Juaniquillo\InputComponentAction\Utilities\Support;

abstract class AbstractInputGroup implements InputGroup
{
    use HasError,
        HasHelpText,
        HasLabel,
        HasWrapper,
        IsInputGroup;

    /** @var array<int, Slot> */
    protected array $slots = [Slot::LABEL, Slot::INPUT, Slot::ERROR];

    protected bool $wrap = true;

    protected bool $labelWrapsInput = false;

    protected bool $requiresLabel = false;

    public function getGroup(): BackendComponent|ContentComponent
    {
        $wrapper = $this->wrap
            ? ($this->getWrapperComponent() ?? Support::getCollectionWrapper())
            : Support::getCollectionWrapper();

        $label = $this->shouldBuildLabel() ? $this->getLabelComponent() : null;

        if ($this->requiresLabel && ! $label) {
            throw new Exception('The label is mandatory to use this group', 500);
        }

        if ($this->labelWrapsInput && $label) {
            $label->setContent($this->getInputComponent(), 'input');
        }

        $components = [];

        foreach ($this->slots as $slot) {
            if ($slot === Slot::INPUT && $this->labelWrapsInput) {
                continue;
            }

            $component = match ($slot) {
                Slot::LABEL => $label,
                Slot::HELP_TEXT => $this->getHelpTextComponent(),
                Slot::INPUT => $this->getInputComponent(),
                Slot::ERROR => $this->getErrorComponent(),
                Slot::WRAPPER => null,
            };

            if ($component) {
                $components[] = $component;
            }
        }

        return $wrapper->setContents($components);
    }

    private function shouldBuildLabel(): bool
    {
        return $this->labelWrapsInput || \in_array(Slot::LABEL, $this->slots, true);
    }
}
