<?php

declare(strict_types=1);

namespace App\Domain\Exception;

use Throwable;

class ValidationException extends MultiResponseException
{
    use DebugTrait;
    private array $validationErrors;
    private bool $translatable;

    private function __construct(array $validationErrors, bool $translatable = false)
    {
        parent::__construct('');

        $this->validationErrors = $validationErrors;
        $this->translatable = $translatable;
    }

    public function getMessagesForEndUser(): array
    {
        return $this->validationErrors;
    }

    public static function fromSingleViolation(string $field, string $errorMessage): ValidationException
    {
        return new self([$field => $errorMessage], true);
    }

    public static function fromMultiViolations(array $errorMessages): self
    {
        return new self($errorMessages);
    }

    public function isTranslatable(): bool
    {
        return $this->translatable;
    }
}
