<?php

declare(strict_types=1);

namespace App\Domain\ValueObject;

use App\Domain\Exception\DomainException;

class Uuid
{
    private string $value;

    private function __construct(string $uuidValue)
    {
        $this->value = $uuidValue;
    }

    public function __toString(): string
    {
        return $this->value;
    }

    public static function create(): self
    {
        return new self(uuid_create(UUID_TYPE_RANDOM));
    }

    public static function createFrom(string $uuidValue): self
    {
        if (!self::isValid($uuidValue)) {
            throw DomainException::from('uuid.invalid.format');
        }
        return new self($uuidValue);
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public static function isValid(string $uuidValue): bool
    {
        return preg_match(
                '/^[0-9A-F]{8}-[0-9A-F]{4}-4[0-9A-F]{3}-[89AB][0-9A-F]{3}-[0-9A-F]{12}$/i',
                $uuidValue
            ) === 1;
    }
}
