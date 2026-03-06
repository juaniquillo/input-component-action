<?php

declare(strict_types=1);

namespace Juaniquillo\InputComponentAction\Concerns;

use Juaniquillo\BackendComponents\Contracts\BackendComponent;
use Juaniquillo\BackendComponents\Contracts\ContentComponent;
use Juaniquillo\BackendComponents\Contracts\ThemeComponent;
use Juaniquillo\InputComponentAction\Composers\LabelComposer;
use Juaniquillo\InputComponentAction\Utilities\Support;

trait HasLabel
{
    private function getLabelComponent(): BackendComponent|ContentComponent|ThemeComponent|null
    {
        $recipe = Support::getRecipe($this->input);

        if ($recipe->getDisableBag()?->disableLabel()) {
            return null;
        }

        $composer = new LabelComposer(
            input: $this->input,
            recipe: $this->recipe,
            themeManager: $this->themeManager,
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
