<?php

declare(strict_types=1);

namespace App\Application\Service;

use App\Domain\Exception\ValidationException;

interface Validator
{
    /**
     * @throws ValidationException
     */
    public function validate(object $object): void;
}
