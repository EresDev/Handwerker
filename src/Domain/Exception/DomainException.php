<?php

declare(strict_types=1);

namespace App\Domain\Exception;

class DomainException extends BaseException
{
    use DebugTrait;
    /**
     * @var array<int, string>|array<string, string>
     */
    private array $violations;

    /**
     * @param array<int, string>|array<string, string> $violations
     */
    protected function __construct(array $violations)
    {
        $this->violations = $violations;
    }

    /**
     * @param array<int, string>|array<string, string> $violations
     */
    public static function fromViolations(array $violations): self
    {
        return new static($violations);
    }

    public static function fromViolation(string $violation): self
    {
        return new static([$violation]);
    }

    public function getViolations(): array
    {
        return $this->violations;
    }
}

