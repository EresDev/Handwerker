<?php

namespace App\Application\UseCase;

abstract class UseCase
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
