<?php

namespace App\Application\Service;

interface PasswordEncoder
{
    public function encode(string $password, string $salt): string;
}
