<?php

declare(strict_types=1);

namespace App\Domain\Exception;

class DomainException extends BaseException
{
    /**
     * @var array<int, string>|array<string, string>
     */
    private array $violations;

    /**
     * @param array<int, string>|array<string, string> $violations
     */
    private function __construct(array $violations)
    {
        $this->violations = $violations;
    }

    /**
     * @param array<int, string>|array<string, string> $violations
     */
    public static function fromMessages(array $violations): self
    {
        return new self($violations);
    }

    public static function fromMessage(string $violation): self
    {
        return new self([$violation]);
    }

    public function getViolations(): array
    {
        return $this->violations;
    }
}

