<?php

declare(strict_types=1);

namespace Juaniquillo\InputComponentAction\Concerns;

use Juaniquillo\BackendComponents\Contracts\BackendComponent;
use Juaniquillo\BackendComponents\Contracts\ContentComponent;
use Juaniquillo\BackendComponents\Contracts\ThemeComponent;
use Juaniquillo\InputComponentAction\Composers\SlotComposer;
use Juaniquillo\InputComponentAction\Enums\Slot;

trait HasError
{
    private function getErrorComponent(): BackendComponent|ContentComponent|ThemeComponent|null
    {
        $recipe = $this->recipe;

        if ($recipe->getDisableBag()?->disableError()) {
            return null;
        }

        $error = $this->errors->resolve($this->input, $recipe);

        if ($error === null || $error === '') {
            return null;
        }

        $composer = new SlotComposer(
            slot: Slot::ERROR,
            input: $this->input,
            recipe: $this->recipe,
            themeManager: $this->themeManager,
            componentBag: $this->defaultComponentBag,
            values: $this->values,
            errors: $this->errors,
            themeBag: $this->defaultThemeBag,
            resolvedError: $error,
        );

        if ($this->parent) {
            $composer->setParent($this->parent);
        }

        return $composer->build();
    }
}
