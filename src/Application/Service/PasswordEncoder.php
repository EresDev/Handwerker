<?php

declare(strict_types=1);

namespace App\Application\Service;

interface PasswordEncoder
{
    public function encode(string $password): string;
}
