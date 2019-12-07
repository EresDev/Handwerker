<?php

namespace App\Infrastructure\Validator\Symfony;

use App\Domain\Service\Validator;
use App\Domain\ValueObject\ValidatorResponse;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ValidatorAdapter implements Validator
{
    private $validator;

    public function __construct(ValidatorInterface $validator)
    {
        $this->validator = $validator;
    }

    public function validate(object $object): ValidatorResponse
    {
        $constraintViolations = $this->validator->validate($object);

        if (count($constraintViolations) > 0) {
            return new ValidatorResponse(false, $this->extractErrors($constraintViolations));
        }

        return new ValidatorResponse(true, []);
    }

    private function extractErrors(
        ConstraintViolationListInterface $constraintViolationList
    ): array {
        $errors = [];
        foreach ($constraintViolationList as $index => $constraintViolation) {
            $propertyNameOfEntity = $constraintViolation->getPropertyPath();
            $errors[$index][$propertyNameOfEntity] = $constraintViolation->getMessage();
        }
        $errors;
        return $errors;
    }
}
