<?php

declare(strict_types=1);

namespace Juaniquillo\InputComponentAction\Concerns;

use Juaniquillo\BackendComponents\Contracts\BackendComponent;
use Juaniquillo\BackendComponents\Contracts\ContentComponent;
use Juaniquillo\BackendComponents\Contracts\ThemeComponent;
use Juaniquillo\InputComponentAction\Composers\SlotComposer;
use Juaniquillo\InputComponentAction\Enums\Slot;

trait HasLabel
{
    private function getLabelComponent(): BackendComponent|ContentComponent|ThemeComponent|null
    {
        $recipe = $this->recipe;

        if ($recipe->getDisableBag()?->disableLabel()) {
            return null;
        }

        $composer = new SlotComposer(
            slot: Slot::LABEL,
            input: $this->input,
            recipe: $this->recipe,
            themeManager: $this->themeManager,
            componentBag: $this->defaultComponentBag,
            values: $this->values,
            errors: $this->errors,
            themeBag: $this->defaultThemeBag,
        );

        if ($this->parent) {
            $composer->setParent($this->parent);
        }

        return $composer->build();

    }
}
