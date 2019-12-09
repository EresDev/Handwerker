<?php

namespace App\Application\UseCaseHandler;

use App\Domain\Entity\User;
use App\Domain\Repository\User\UserSaver;
use App\Service\Security\Role;
use App\Service\PasswordEncoder;
use App\Service\Validator;
use App\Application\UseCase\RegisterUser;

class RegisterUserHandler
{
    private PasswordEncoder $passwordEncoder;
    private Validator $validator;
    private UserSaver $userSaver;

    public function __construct(
        PasswordEncoder $passwordEncoder,
        Validator $validator,
        UserSaver $userSaver
    ) {
        $this->passwordEncoder = $passwordEncoder;
        $this->validator = $validator;
        $this->userSaver = $userSaver;
    }

    public function handle(RegisterUser $command): void
    {
        $this->validator->validate($command);

        $user = new User();
        $user->setUuid($command->getUuid());
        $user->setEmail($command->getEmail());

        $encodedPassword = $this->passwordEncoder->encode(
            $command->getPassword(),
            $user->getSalt()
        );

        $user->setPassword($encodedPassword);

        $user->setRoles([Role::USER]);

        $this->userSaver->save($user);
    }
}
