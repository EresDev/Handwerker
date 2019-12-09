<?php

namespace App\Service;

interface PasswordEncoder
{
    public function encode(string $password, string $salt): string;
}
