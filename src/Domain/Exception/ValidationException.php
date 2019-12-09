<?php

namespace App\Domain\Exception;

use Throwable;

class ValidationException extends MultiResponseException
{
    private $validationErrors;

    public function __construct(
        array $validationErrors,
        string $message = "",
        int $code = 0,
        Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
        $this->validationErrors = $validationErrors;
    }

    public function getMessagesForEndUser(): array
    {
        return $this->validationErrors;
    }
}
