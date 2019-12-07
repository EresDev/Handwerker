<?php

namespace App\Domain\Exception;

use Throwable;

class ValidationException extends BaseException
{
    private $validationErrors;

    public function __construct(
        array $validationErrors,
        string $message = "",
        int $code = 0,
        Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }

    public function getMessageForEndUser(): string
    {
        return 'The submitted data was not valid.';
    }

    public function getValidationErrors() : array
    {
        return $this->validationErrors;
    }

}
