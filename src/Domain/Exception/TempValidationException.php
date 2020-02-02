<?php

declare(strict_types=1);

namespace App\Domain\Exception;

class TempValidationException extends BaseException
{
    use DebugTrait;
    /**
     * @var array<string, string>
     */
    private array $violations;

    /**
     * @param array<string, string> $violations
     */
    protected function __construct(array $violations)
    {
        $this->violations = $violations;
    }

    /**
     * @param array<string, string> $violations
     */
    public static function from(array $violations): self
    {
        return new static($violations);
    }

    public function getViolations(): array
    {
        return $this->violations;
    }
}
