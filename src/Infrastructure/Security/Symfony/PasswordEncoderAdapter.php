<?php

namespace App\Infrastructure\Security\Symfony;

use App\Application\Service\PasswordEncoder;
use Faker\Provider\Base as BaseProvider;
use Symfony\Component\Security\Core\Encoder\PasswordEncoderInterface;

class PasswordEncoderAdapter extends BaseProvider implements PasswordEncoder
{
    private $passwordEncoder;

    public function __construct(PasswordEncoderInterface $passwordEncoder)
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
