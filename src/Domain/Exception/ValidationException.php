<?php

declare(strict_types=1);

namespace App\Domain\Exception;

use Throwable;

class ValidationException extends MultiResponseException
{
    use DebugTrait;
    private array $validationErrors;

    private function __construct(array $validationErrors)
    {
        parent::__construct('');
        $this->validationErrors = $validationErrors;
    }

    public function getMessagesForEndUser(): array
    {
        return $this->validationErrors;
    }

    public static function fromSingleViolation(string $field, string $errorMessage): ValidationException
    {
        return new self([[$field => $errorMessage]]);
    }

    public static function fromMultiViolations(array $errorMessages): self
    {
        return new self($errorMessages);
    }
}
