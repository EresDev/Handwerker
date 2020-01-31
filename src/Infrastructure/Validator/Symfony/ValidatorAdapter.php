<?php

declare(strict_types=1);

namespace App\Infrastructure\Validator\Symfony;

use App\Application\Service\Validator;
use App\Domain\Exception\ValidationException;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ValidatorAdapter implements Validator
{
    private ValidatorInterface $validator;

    public function __construct(ValidatorInterface $validator)
    {
        $this->validator = $validator;
    }

    public function validate(object $object): void
    {
        $constraintViolations = $this->validator->validate($object);

        if (count($constraintViolations) > 0) {
            $errors = $this->extractErrors($constraintViolations);
            throw ValidationException::fromViolations($errors)
                ->withDebugInfo(
                    sprintf(
                        "Validation failed for %s \nGiven Object: %s\nValidation errors are: \n%s",
                        get_class($object),
                        $object,
                        json_encode($errors)
                    )
                );
        }
    }

    private function extractErrors(
        ConstraintViolationListInterface $constraintViolationList
    ): array {
        $errors = [];
        foreach ($constraintViolationList as $index => $constraintViolation) {
            $propertyNameOfEntity = $constraintViolation->getPropertyPath();
            $errors[$propertyNameOfEntity] = $constraintViolation->getMessage();
        }
        $errors;
        return $errors;
    }
}
