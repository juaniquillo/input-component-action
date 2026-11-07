<?php

declare(strict_types=1);

namespace Tests;

use Juaniquillo\CrudAssistant\Contracts\InputCollectionInterface;
use Juaniquillo\CrudAssistant\CrudAssistant;
use Juaniquillo\CrudAssistant\Inputs\DefaultInput;

class Collections
{
    public static function simple(): InputCollectionInterface
    {
        return CrudAssistant::make([
            new DefaultInput('name', 'Name'),
            new DefaultInput('email', 'Email'),
            new DefaultInput('phone', 'Phone'),
            new DefaultInput('description', 'Description'),
        ]);
    }
}
