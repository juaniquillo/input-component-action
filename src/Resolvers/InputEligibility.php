<?php

declare(strict_types=1);

namespace Juaniquillo\InputComponentAction\Resolvers;

use Juaniquillo\CrudAssistant\Contracts\InputInterface;

/**
 * Decides whether an input is addressed to the current action.
 */
final class InputEligibility
{
    public function __construct(
        private string $identifier,
    ) {}

    public function getIdentifier(): string
    {
        return $this->identifier;
    }

    public function isResolvable(InputInterface $input): bool
    {
        $recipe = $input->getRecipe($this->identifier);

        if ($recipe && $recipe->isIgnored()) {
            return false;
        }

        return $input->isFor($this->identifier);
    }
}
