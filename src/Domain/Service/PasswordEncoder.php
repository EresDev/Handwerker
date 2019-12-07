<?php

namespace App\Domain\Service;

interface PasswordEncoder
{
    public function encode(string $password, string $salt): string;
}
