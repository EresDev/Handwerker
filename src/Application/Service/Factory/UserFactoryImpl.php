<?php

declare(strict_types=1);

namespace App\Application\Service\Factory;

use App\Application\Command\RegisterUserCommand;
use App\Application\Service\PasswordEncoder;
use App\Application\Service\Security\Role;
use App\Domain\Entity\User;

class UserFactoryImpl implements UserFactory
{
    private PasswordEncoder $passwordEncoder;

    public function __construct(PasswordEncoder $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function create(RegisterUserCommand $command): User
    {
        $encodedPassword = $this->passwordEncoder->encode($command->getPassword());

        return new User(
            $command->getUuid(),
            $command->getEmail(),
            $encodedPassword,
            [Role::USER]
        );
    }
}
