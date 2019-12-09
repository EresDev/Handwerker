<?php

namespace App\Service;

use App\Domain\Exception\ValidationException;

interface Validator
{
    /**
     * @throws ValidationException
     */
    public function validate(object $object): void;
}
