<?php

namespace App\Domain\Service;

use App\Domain\Exception\ValidationException;
use App\Domain\ValueObject\ValidatorResponse;

interface Validator
{
    public function validate(object $object) : ValidatorResponse;
}
