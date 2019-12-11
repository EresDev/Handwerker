<?php

namespace App\Infrastructure\Validator\Symfony;

use Symfony\Component\Validator\Tests\Fixtures\ClassConstraint;

class UniqueEntityConstraint extends ClassConstraint
{
    public $message = 'The "{{ string }}" is already in use.';
    public $entityClass;
    public $fields;

    public function getRequiredOptions()
    {
        return ['entityClass'];
    }
}

