<?php

namespace Juaniquillo\InputComponentAction\Bags;

use Juaniquillo\BackendComponents\Contracts\BackendComponent;
use Juaniquillo\BackendComponents\Contracts\CompoundComponent;

final class DefaultComponentBag
{
    /** 
     * @var CompoundComponent|BackendComponent|class-string{CompoundComponent|BackendComponent}|null
     */
    private CompoundComponent|BackendComponent|string|null $inputComponent = null;

    /** 
     * @var CompoundComponent|BackendComponent|class-string{CompoundComponent|BackendComponent}|null
     */
    private CompoundComponent|BackendComponent|string|null $wrapperComponent = null;

    /** 
     * @var CompoundComponent|BackendComponent|class-string{CompoundComponent|BackendComponent}|null
     */
    private CompoundComponent|BackendComponent|string|null $labelComponent = null;

    /** 
     * @var CompoundComponent|BackendComponent|class-string{CompoundComponent|BackendComponent}|null
     */
    private CompoundComponent|BackendComponent|string|null $errorComponent = null;

    /** 
     * @var CompoundComponent|BackendComponent|class-string{CompoundComponent|BackendComponent}|null
     */
    private CompoundComponent|BackendComponent|string|null $helpTextComponent = null;

    public function getInputComponent(): BackendComponent|CompoundComponent|string|null
    {
        return $this->inputComponent;
    }

    public function setInputComponent($inputComponent)
    {
        $this->inputComponent = $inputComponent;

        return $this;
    }

    public function getWrapperComponent(): BackendComponent|CompoundComponent|string|null
    {
        return $this->wrapperComponent;
    }

    public function setWrapperComponent($wrapperComponent)
    {
        $this->wrapperComponent = $wrapperComponent;

        return $this;
    }


    public function getLabelComponent(): BackendComponent|CompoundComponent|string|null
    {
        return $this->labelComponent;
    }

    public function setLabelComponent($labelComponent)
    {
        $this->labelComponent = $labelComponent;

        return $this;
    }

    public function getErrorComponent(): BackendComponent|CompoundComponent|string|null
    {
        return $this->errorComponent;
    }

    public function setErrorComponent($errorComponent)
    {
        $this->errorComponent = $errorComponent;

        return $this;
    }

    public function getHelpTextComponent(): BackendComponent|CompoundComponent|string|null
    {
        return $this->helpTextComponent;
    }

 
    public function setHelpTextComponent($helpTextComponent)
    {
        $this->helpTextComponent = $helpTextComponent;

        return $this;
    }
}
