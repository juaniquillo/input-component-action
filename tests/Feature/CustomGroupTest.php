<?php

declare(strict_types=1);

namespace Tests\Feature;

use Juaniquillo\BackendComponents\Contracts\BackendComponent;
use Juaniquillo\BackendComponents\Contracts\ContentComponent;
use Juaniquillo\BackendComponents\Enums\ComponentEnum;
use Juaniquillo\CrudAssistant\CrudAssistant;
use Juaniquillo\CrudAssistant\Inputs\DefaultInput;
use Juaniquillo\InputComponentAction\Concerns\HasLabel;
use Juaniquillo\InputComponentAction\Concerns\HasWrapper;
use Juaniquillo\InputComponentAction\Concerns\IsInputGroup;
use Juaniquillo\InputComponentAction\Contracts\InputGroup;
use Juaniquillo\InputComponentAction\Recipes\InputComponentRecipe;
use Juaniquillo\InputComponentAction\Utilities\Support;
use Tests\Support\ActionFactory;
use Tests\Support\ComponentTree;

final class CustomLabelGroup implements InputGroup
{
    use HasLabel,
        HasWrapper,
        IsInputGroup;

    public function getGroup(): BackendComponent|ContentComponent
    {
        $wrapper = $this->getWrapperComponent() ?? Support::getCollectionWrapper();
        $label = $this->getLabelComponent();
        $input = $this->getInputComponent();

        $components = [];

        if ($label) {
            $components[] = $label;
        }

        $components[] = $input;

        return $wrapper->setContents($components);
    }
}

test('a custom group using the input group trait works with the context', function (): void {
    $input = new DefaultInput('name', 'Name');
    $input->setRecipe(new InputComponentRecipe(inputGroup: new CustomLabelGroup));

    $component = ActionFactory::component(CrudAssistant::make([$input]), 'name');
    $children = array_values(ComponentTree::of($component)['contents']);

    expect(array_column($children, 'type'))->toBe([
        ComponentEnum::LABEL->value,
        ComponentEnum::TEXT_INPUT->value,
    ]);
});
