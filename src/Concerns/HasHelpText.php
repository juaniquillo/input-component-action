<?php

declare(strict_types=1);

namespace Juaniquillo\InputComponentAction\Concerns;

use Juaniquillo\BackendComponents\Contracts\BackendComponent;
use Juaniquillo\BackendComponents\Contracts\ContentComponent;
use Juaniquillo\BackendComponents\Contracts\ThemeComponent;
use Juaniquillo\InputComponentAction\Composers\HelpTextComposer;
use Juaniquillo\InputComponentAction\Utilities\Support;

trait HasHelpText
{
    private function getHelpTextComponent(): BackendComponent|ContentComponent|ThemeComponent|null
    {
        $recipe = Support::getRecipe($this->input);

        if ($recipe->getDisableBag()?->disableHelpText() || $recipe->getHelpText() === null) {
            return null;
        }

        $composer = new HelpTextComposer(
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
