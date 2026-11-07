<?php

declare(strict_types=1);

namespace Juaniquillo\InputComponentAction\Concerns;

use Juaniquillo\BackendComponents\Contracts\BackendComponent;
use Juaniquillo\BackendComponents\Contracts\ContentComponent;
use Juaniquillo\BackendComponents\Contracts\ThemeComponent;
use Juaniquillo\InputComponentAction\Composers\WrapperComposer;

trait HasWrapper
{
    private function getWrapperComponent(): BackendComponent|ContentComponent|ThemeComponent|null
    {
        $recipe = $this->recipe;

        if ($recipe->getDisableBag()?->disableWrapper()) {
            return null;
        }

        $composer = new WrapperComposer(
            input: $this->input,
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
