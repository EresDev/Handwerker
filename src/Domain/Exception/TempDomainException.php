<?php

declare(strict_types=1);

namespace App\Domain\Exception;

class TempDomainException extends BaseException
{
    use DebugTrait;
    private string $violation;

    protected function __construct(string $violation)
    {
        $this->violation = $violation;
    }

    public static function from(string $violation): self
    {
        return new static($violation);
    }

    public function getViolation(): string
    {
        return $this->violation;
    }
}
