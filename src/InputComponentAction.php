<?php

declare(strict_types=1);

namespace Juaniquillo\InputComponentAction;

use Exception;
use Juaniquillo\BackendComponents\Contracts\BackendComponent;
use Juaniquillo\BackendComponents\Contracts\ContentComponent;
use Juaniquillo\BackendComponents\Contracts\ThemeComponent;
use Juaniquillo\BackendComponents\Contracts\ThemeManager;
use Juaniquillo\CrudAssistant\Concerns\IsAction;
use Juaniquillo\CrudAssistant\Contracts\ActionInterface;
use Juaniquillo\CrudAssistant\Contracts\InputInterface;
use Juaniquillo\CrudAssistant\CrudAssistant;
use Juaniquillo\CrudAssistant\DataContainer;
use Juaniquillo\CrudAssistant\InputCollection;
use Juaniquillo\InputComponentAction\Composers\WrapperComposer;
use Juaniquillo\InputComponentAction\Containers\InputComponentOutput;
use Juaniquillo\InputComponentAction\Contracts\ErrorManager;
use Juaniquillo\InputComponentAction\Contracts\ErrorTheme;
use Juaniquillo\InputComponentAction\Contracts\HelpTextTheme;
use Juaniquillo\InputComponentAction\Contracts\InputGroup;
use Juaniquillo\InputComponentAction\Contracts\LabelTheme;
use Juaniquillo\InputComponentAction\Contracts\ThemeBag;
use Juaniquillo\InputComponentAction\Contracts\ValueManager;
use Juaniquillo\InputComponentAction\Contracts\WrapperTheme;
use Juaniquillo\InputComponentAction\Factories\InputGroupFactory;
use Juaniquillo\InputComponentAction\Managers\DefaultErrorManager;
use Juaniquillo\InputComponentAction\Managers\DefaultValueManager;
use Juaniquillo\InputComponentAction\Recipes\InputComponentRecipe;
use Juaniquillo\InputComponentAction\Utilities\Support;

final class InputComponentAction implements ActionInterface
{
    use IsAction;

    protected $controlsRecursion = true;

    private ?ThemeManager $defaultThemeManager = null;

    private ?InputGroup $defaultInputGroup = null;

    private ThemeBag|WrapperTheme|LabelTheme|ErrorTheme|HelpTextTheme|null $defaultThemeBag = null;

    private ?object $model = null;

    private ?ValueManager $valueBag = null;

    private ?ErrorManager $errorBag = null;

    public function __construct(
        private array $values = [],
        private array $errors = [],
    ) {
        $this->output = new InputComponentOutput;

        $this->output->inputs = new DataContainer;
        $this->output->meta = new DataContainer;
    }

    public static function make(array $values = [], array $errors = []): static
    {
        return new self(values: $values, errors: $errors);
    }

    public function setThemeManager(ThemeManager $defaultThemeManager): static
    {
        $this->defaultThemeManager = $defaultThemeManager;

        return $this;
    }

    public function setDefaultInputGroup(InputGroup $defaultInputGroup): static
    {
        $this->defaultInputGroup = $defaultInputGroup;

        return $this;
    }

    public function setDefaultThemeBag(ThemeBag|WrapperTheme|LabelTheme|ErrorTheme|HelpTextTheme $defaultThemeBag): static
    {
        $this->defaultThemeBag = $defaultThemeBag;

        return $this;
    }

    public function setModel(?object $model = null): static
    {
        $this->model = $model;

        return $this;
    }

    public function setValueManager(ValueManager $valueBag): static
    {
        $this->valueBag = $valueBag;

        return $this;
    }

    public function setErrorManager(ErrorManager $errorBag): static
    {
        $this->errorBag = $errorBag;

        return $this;
    }

    public function execute(InputCollection|InputInterface|\IteratorAggregate $input)
    {
        /** @var InputComponentOutput $output */
        $output = $this->output;
        $inputs = $output->inputs;

        $name = $input->getName();

        if (! $name) {
            throw new Exception(message: 'The Input '.$input::class.' must have a name', code: 500);
        }

        $inputs->set($name, $this->resolveInputs($input));

        return $this->output;
    }

    public function resolveInputs(InputCollection|InputInterface|\IteratorAggregate $input): array|BackendComponent|ContentComponent
    {
        /**
         * Recursively resolve inputs
         * and input collections.
         */
        if (CrudAssistant::isInputCollection($input) && $this->controlsRecursion()) {
            $wrapper = $this->getWrapper($input);

            foreach ($input as $item) {
                $wrapper->setContent($this->resolveInputs($item));
            }

            return $wrapper;
        }

        $inputGroup = $this->getInputGroup($input);

        /** Modifiers on the whole input group component */
        $component = $this->modifiers(
            value: $inputGroup,
            input: $input,
        );

        return $component;

    }

    public function getInputGroup(InputInterface $input): BackendComponent
    {
        $recipe = Support::getRecipe($input);

        return InputGroupFactory::initGroup(
            input: $input,
            recipe: $recipe,
            values: $this->getValueManager($recipe),
            errors: $this->getErrorManager($recipe),
            defaultThemeManager: $this->defaultThemeManager,
            defaultInputGroup: $this->defaultInputGroup,
            defaultThemeBag: $this->defaultThemeBag,
        );

    }

    public function getWrapper(InputInterface $input): BackendComponent|ContentComponent|ThemeComponent
    {
        $recipe = Support::getRecipe($input);

        $composer = new WrapperComposer(
            input: $input,
            themeManager: Support::resolveThemeManager(recipe: $recipe, defaultThemeManager: $this->defaultThemeManager),
            themeBag: $this->defaultThemeBag,
        );

        return $composer->build();
    }

    public function getValueManager(?InputComponentRecipe $recipe): ValueManager
    {
        $bag = $recipe->valueBag ?? $this->valueBag ?? new DefaultValueManager;

        return $bag->setValues($this->values)
            ->setModel($this->model);
    }

    public function getErrorManager(?InputComponentRecipe $recipe): ErrorManager
    {
        $bag = $recipe->errorBag ?? $this->errorBag ?? new DefaultErrorManager;

        return $bag->setErrors($this->errors);
    }

    public function cleanup(): static
    {
        return $this;
    }
}
