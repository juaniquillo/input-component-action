<?php

declare(strict_types=1);

namespace Juaniquillo\InputComponentAction\Concerns;

use Closure;

trait IsThemeBag
{
    /** @var Closure|array<string, string|array<int|string, string>>|null */
    private Closure|array|null $inputTheme = null;

    /** @var Closure|array<string, string|array<int|string, string>>|null */
    private Closure|array|null $wrapperTheme = null;

    /** @var Closure|array<string, string|array<int|string, string>>|null */
    private Closure|array|null $labelTheme = null;

    /** @var Closure|array<string, string|array<int|string, string>>|null */
    private Closure|array|null $errorTheme = null;

    /** @var Closure|array<string, string|array<int|string, string>>|null */
    private Closure|array|null $helpTextTheme = null;

    /** @param Closure|array<string, string|array<int|string, string>> $inputTheme */
    public function setInputTheme(Closure|array $inputTheme): static
    {
        $this->inputTheme = $inputTheme;

        return $this;
    }

    /** @return Closure|array<string, string|array<int|string, string>>|null */
    public function getInputTheme(): Closure|array|null
    {
        return $this->inputTheme;
    }

    /** @param Closure|array<string, string|array<int|string, string>> $wrapperTheme */
    public function setWrapperTheme(Closure|array $wrapperTheme): static
    {
        $this->wrapperTheme = $wrapperTheme;

        return $this;
    }

    /** @return Closure|array<string, string|array<int|string, string>>|null */
    public function getWrapperTheme(): Closure|array|null
    {
        return $this->wrapperTheme;
    }

    /** @param Closure|array<string, string|array<int|string, string>> $labelTheme */
    public function setLabelTheme(Closure|array $labelTheme): static
    {
        $this->labelTheme = $labelTheme;

        return $this;
    }

    /** @return Closure|array<string, string|array<int|string, string>>|null */
    public function getLabelTheme(): Closure|array|null
    {
        return $this->labelTheme;
    }

    /** @param Closure|array<string, string|array<int|string, string>> $errorTheme */
    public function setErrorTheme(Closure|array $errorTheme): static
    {
        $this->errorTheme = $errorTheme;

        return $this;
    }

    /** @return Closure|array<string, string|array<int|string, string>>|null */
    public function getErrorTheme(): Closure|array|null
    {
        return $this->errorTheme;
    }

    /** @param Closure|array<string, string|array<int|string, string>> $helpTextTheme */
    public function setHelpTextTheme(Closure|array $helpTextTheme): static
    {
        $this->helpTextTheme = $helpTextTheme;

        return $this;
    }

    /** @return Closure|array<string, string|array<int|string, string>>|null */
    public function getHelpTextTheme(): Closure|array|null
    {
        return $this->helpTextTheme;
    }
}
