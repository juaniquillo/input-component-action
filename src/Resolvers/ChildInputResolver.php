<?php

declare(strict_types=1);

namespace Juaniquillo\InputComponentAction\Resolvers;

use Closure;
use Juaniquillo\BackendComponents\Contracts\BackendComponent;
use Juaniquillo\BackendComponents\Contracts\ContentComponent;
use Juaniquillo\CrudAssistant\Contracts\InputInterface;
use Juaniquillo\InputComponentAction\Contracts\ComponentBag;
use Juaniquillo\InputComponentAction\Contracts\ErrorManager;
use Juaniquillo\InputComponentAction\Contracts\ThemeBag;
use Juaniquillo\InputComponentAction\Contracts\ValueManager;
use Juaniquillo\InputComponentAction\Factories\InputGroupFactory;
use Juaniquillo\InputComponentAction\Groups\GroupContext;
use Juaniquillo\InputComponentAction\Utilities\Support;

/**
 * Resolves the sub-elements of an input into renderable components.
 */
final class ChildInputResolver
{
    public function __construct(
        private InputEligibility $eligibility,
        private ValueManager $values,
        private ErrorManager $errors,
        private ComponentBag $componentBag,
        private string|Closure $defaultInputGroup,
        private string|Closure|null $defaultThemeManager,
        private ?ThemeBag $themeBag = null,
    ) {}

    public function canResolve(InputInterface $input): bool
    {
        return $this->eligibility->isResolvable($input);
    }

    public function hasResolvableSubElements(InputInterface $input): bool
    {
        $subElements = $input->getSubElements();

        if (! $subElements) {
            return false;
        }

        foreach ($subElements->getInputs() as $child) {
            if ($this->canResolve($child)) {
                return true;
            }
        }

        return false;
    }

    /**
     * @return array<int, BackendComponent&ContentComponent>|null
     */
    public function resolveChildren(InputInterface $input): ?array
    {
        $subElements = $input->getSubElements();

        if (! $subElements) {
            return null;
        }

        $components = [];

        foreach ($subElements->getInputs() as $child) {
            if (! $this->canResolve($child)) {
                continue;
            }

            $components[] = $this->resolve($child, $input);
        }

        return $components === [] ? null : $components;
    }

    public function resolve(
        InputInterface $input,
        ?InputInterface $parent = null,
    ): BackendComponent&ContentComponent {
        $recipe = Support::getRecipe($input);

        return InputGroupFactory::init(new GroupContext(
            input: $input,
            recipe: $recipe,
            eligibility: $this->eligibility,
            themeManager: $recipe->getThemeManager() ?? Support::resolveThemeManager($this->defaultThemeManager),
            defaultThemeManager: $this->defaultThemeManager,
            defaultComponentBag: $this->componentBag,
            defaultInputGroup: $this->defaultInputGroup,
            values: $this->values,
            errors: $this->errors,
            defaultThemeBag: $this->themeBag,
            parent: $parent,
        ));
    }
}
