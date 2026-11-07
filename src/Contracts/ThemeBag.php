<?php

declare(strict_types=1);

namespace Juaniquillo\InputComponentAction\Contracts;

use Closure;

interface ThemeBag
{
    public function setInputTheme(Closure|array $inputTheme): static;

    public function getInputTheme(): Closure|array|null;

    public function setWrapperTheme(Closure|array $wrapperTheme): static;

    public function getWrapperTheme(): Closure|array|null;

    public function setLabelTheme(Closure|array $labelTheme): static;

    public function getLabelTheme(): Closure|array|null;

    public function setErrorTheme(Closure|array $errorTheme): static;

    public function getErrorTheme(): Closure|array|null;

    public function setHelpTextTheme(Closure|array $helpTextTheme): static;

    public function getHelpTextTheme(): Closure|array|null;
}
