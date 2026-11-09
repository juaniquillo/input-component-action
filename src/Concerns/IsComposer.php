<?php

declare(strict_types=1);

namespace Juaniquillo\InputComponentAction\Concerns;

use BackedEnum;
use Closure;
use Exception;
use Juaniquillo\BackendComponents\Contracts\BackendComponent;
use Juaniquillo\BackendComponents\Contracts\ContentComponent;
use Juaniquillo\BackendComponents\Contracts\ThemeComponent;
use Juaniquillo\CrudAssistant\Contracts\InputInterface;
use Juaniquillo\InputComponentAction\Contracts\ErrorManager;
use Juaniquillo\InputComponentAction\Contracts\ValueManager;

trait IsComposer
{
    private ?InputInterface $parent = null;

    public function setParent(InputInterface $parent): static
    {
        $this->parent = $parent;

        return $this;
    }

    private static function resolveStringClosure(InputInterface $input, string|Closure|null $stringClosure, ?string $value = null, ?string $error = null): ?string
    {
        if ($stringClosure instanceof Closure) {
            $stringClosure = $stringClosure($input, $value, $error);
        }

        return $stringClosure;
    }

    /**
     * @param  array<string, mixed>|Closure|null  $value
     * @return array<string, mixed>|null
     */
    private static function resolveArrayClosure(array|Closure|null $value, InputInterface $input, string|BackedEnum $type): ?array
    {
        if ($value instanceof Closure) {
            return $value($input, $type);
        }

        return $value;
    }

    private function resolveComponentHook(
        BackendComponent&ContentComponent&ThemeComponent $component,
        ?Closure $closure,
        InputInterface $input,
        string|BackedEnum $type,
        ?ValueManager $values = null,
        ?ErrorManager $errors = null,
    ): BackendComponent&ContentComponent&ThemeComponent {
        if ($closure instanceof Closure) {
            $result = $closure(
                $component,
                $input,
                $type,
                $values,
                $errors
            );

            if ($result instanceof BackendComponent && $result instanceof ContentComponent && $result instanceof ThemeComponent) {
                return $result;
            }

            throw new Exception('Component hooks must return a renderable backend component.', 500);
        }

        return $component;
    }
}
