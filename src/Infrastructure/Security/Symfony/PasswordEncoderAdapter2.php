<?php

namespace App\Infrastructure\Security\Symfony;

use App\Domain\Service\PasswordEncoder;
use Symfony\Component\Security\Core\Encoder\NativePasswordEncoder;
use Symfony\Component\Security\Core\Encoder\PasswordEncoderInterface;

class PasswordEncoderAdapter2 implements PasswordEncoder
{
    private $passwordEncoder;

    public function __construct(NativePasswordEncoder $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function encode(string $password, string $salt): string
    {
        return $this->passwordEncoder->encodePassword(
            $password,
            $salt
        );
    }
}
