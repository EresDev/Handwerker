<?php

declare(strict_types=1);

namespace App\Application\Command;

abstract class Command
{
    abstract public function getContent(): array;

    public function __toString(): string
    {
        return print_r(
            static::getContent(),
            true
        );
    }
}
