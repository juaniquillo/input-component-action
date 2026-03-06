<?php

declare(strict_types=1);

namespace Juaniquillo\InputComponentAction\Concerns;

use BackedEnum;
use Closure;
use Juaniquillo\BackendComponents\Contracts\BackendComponent;
use Juaniquillo\BackendComponents\Contracts\ContentComponent;
use Juaniquillo\BackendComponents\Enums\ComponentEnum;
use Juaniquillo\CrudAssistant\Contracts\InputInterface;
use Juaniquillo\CrudAssistant\Contracts\RecipeInterface;
use Juaniquillo\InputComponentAction\Contracts\ErrorManager;
use Juaniquillo\InputComponentAction\Contracts\ValueManager;
use Juaniquillo\InputComponentAction\Recipes\InputComponentRecipe;
use Juaniquillo\InputComponentAction\Utilities\Support;

trait IsComposer
{
    private ?InputInterface $parent = null;

    public function setParent(InputInterface $parent): static
    {
        $this->parent = $parent;

        return $this;
    }

    private static function resolveStringClosure(InputInterface $input, string|Closure|null $stringClosure, ?string $value = null, ?string $error = null): string
    {
        if (Support::isClosure($stringClosure)) {
            $stringClosure = $stringClosure($input, $value, $error);
        }

        return $stringClosure;
    }

    private static function resolveArrayClosure(array|Closure|null $value, InputInterface $input, BackedEnum $type): ?array
    {
        if ($input == null) {
            return null;
        }

        if (Support::isClosure($value)) {
            return $value($input, $type);
        }

        return $value;
    }

    private static function resolveInputName(InputInterface $input, InputComponentRecipe $recipe, ?array $attributes = null): ?string
    {
        $attributes ??= $recipe->getAttributeBag()?->getInputAttributes() ?? null;

        return $attributes['name'] ?? $input->getName();
    }

    private static function resolveInputId(InputInterface $input, InputComponentRecipe $recipe, ?array $attributes = null): ?string
    {
        $attributes ??= $recipe->getAttributeBag()?->getInputAttributes() ?? null;

        return $attributes['id'] ?? $input->getName();
    }

    private function resolveWrapperType(InputComponentRecipe|RecipeInterface|null $recipe): string|ComponentEnum
    {
        return $recipe?->getWrapperType() ?? ComponentEnum::DIV;
    }

    private function resolveLabelType(InputComponentRecipe|RecipeInterface|null $recipe): string|ComponentEnum
    {
        return $recipe?->getLabelType() ?? ComponentEnum::LABEL;
    }

    private function resolveInputType(InputComponentRecipe|RecipeInterface|null $recipe): string|ComponentEnum
    {
        return $recipe?->getInputType() ?? ComponentEnum::TEXT_INPUT;
    }

    private function resolveErrorType(?InputComponentRecipe $recipe): string|ComponentEnum
    {
        return $recipe?->getErrorType() ?? ComponentEnum::PARAGRAPH;
    }

    private function resolveComponentHook(
        BackendComponent $component,
        ?Closure $closure,
        InputInterface $input,
        BackedEnum $type,
        ?ValueManager $values = null,
        ?ErrorManager $errors = null,
    ): BackendComponent|ContentComponent {
        if (Support::isClosure($closure)) {
            $result = $closure(
                $component,
                $input,
                $type,
                $values,
                $errors
            );

            return $result;
        }

        return $component;
    }
}
