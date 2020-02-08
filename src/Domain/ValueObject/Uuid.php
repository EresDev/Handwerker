<?php

declare(strict_types=1);

namespace App\Domain\ValueObject;

use App\Domain\Exception\DomainException;

class Uuid
{
    private string $value;
    public const UUID_PATTERN = '^[0-9a-f]{8}-[0-9a-f]{4}-4[0-9a-f]{3}-[89ab][0-9a-f]{3}-[0-9a-f]{12}$';

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
                '/' . self::UUID_PATTERN . '/',
                $uuidValue
            ) === 1;
    }
}
