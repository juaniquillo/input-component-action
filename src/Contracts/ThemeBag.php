<?php

declare(strict_types=1);

namespace Juaniquillo\InputComponentAction\Contracts;

use Closure;

interface ThemeBag
{
    /** @param Closure|array<string, string|array<int|string, string>> $inputTheme */
    public function setInputTheme(Closure|array $inputTheme): static;

    /** @return Closure|array<string, string|array<int|string, string>>|null */
    public function getInputTheme(): Closure|array|null;

    /** @param Closure|array<string, string|array<int|string, string>> $wrapperTheme */
    public function setWrapperTheme(Closure|array $wrapperTheme): static;

    /** @return Closure|array<string, string|array<int|string, string>>|null */
    public function getWrapperTheme(): Closure|array|null;

    /** @param Closure|array<string, string|array<int|string, string>> $labelTheme */
    public function setLabelTheme(Closure|array $labelTheme): static;

    /** @return Closure|array<string, string|array<int|string, string>>|null */
    public function getLabelTheme(): Closure|array|null;

    /** @param Closure|array<string, string|array<int|string, string>> $errorTheme */
    public function setErrorTheme(Closure|array $errorTheme): static;

    /** @return Closure|array<string, string|array<int|string, string>>|null */
    public function getErrorTheme(): Closure|array|null;

    /** @param Closure|array<string, string|array<int|string, string>> $helpTextTheme */
    public function setHelpTextTheme(Closure|array $helpTextTheme): static;

    /** @return Closure|array<string, string|array<int|string, string>>|null */
    public function getHelpTextTheme(): Closure|array|null;
}
