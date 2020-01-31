<?php

declare(strict_types=1);

namespace App\Domain\Exception;

class ValidationException extends BaseException
{
    use DebugTrait;
    /**
     * @var array<int, string>|array<string, string>
     */
    private array $validationErrors;

    /**
     * @param array<int, string>|array<string, string> $validationErrors
     */
    private function __construct(array $validationErrors)
    {
        parent::__construct('');

        $this->validationErrors = $validationErrors;
    }

    public function getMessages(): array
    {
        return $this->validationErrors;
    }

    public static function fromGeneralViolation(string $errorMessage): ValidationException
    {
        return new self([$errorMessage], true);
    }


    public static function fromMultiViolations(array $errorMessages): self
    {
        return new self($errorMessages);
    }

}
