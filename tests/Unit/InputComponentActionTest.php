<?php

declare(strict_types=1);

use Juaniquillo\CrudAssistant\DataContainer;
use Juaniquillo\InputComponentAction\Containers\InputComponentOutput;
use Juaniquillo\InputComponentAction\InputComponentAction;
use Tests\Collections;

test('the action returns a data container object', function (): void {

    $action = new InputComponentAction;
    $crud = Collections::simple();

    /** @var InputComponentOutput $output */
    $output = $crud->execute($action);

    expect($output)
        ->toBeInstanceOf(InputComponentOutput::class);

});

test('the data container has inputs and meta', function (): void {

    $action = new InputComponentAction;
    $crud = Collections::simple();

    /** @var InputComponentOutput $output */
    $output = $crud->execute($action);

    expect($output->inputs)
        ->toBeInstanceOf(DataContainer::class);
    expect($output->meta)
        ->toBeInstanceOf(DataContainer::class);

});
