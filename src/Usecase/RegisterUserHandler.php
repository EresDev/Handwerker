<?php

namespace App\Usecase;

use App\Domain\Entity\User;
use App\Domain\Repository\SaveRepository;
use App\Domain\Security\Role;
use App\Domain\Service\PasswordEncoder;
use App\Domain\Service\Validator;
use App\Usecase\Command\RegisterUserCommand;

class RegisterUserHandler
{
    private PasswordEncoder $passwordEncoder;
    private Validator $validator;
    private SaveRepository $saveRepository;

    public function __construct(
        PasswordEncoder $passwordEncoder,
        Validator $validator,
        SaveRepository $saveRepository
    ) {
        $this->passwordEncoder = $passwordEncoder;
        $this->validator = $validator;
        $this->saveRepository = $saveRepository;
    }

    public function handle(RegisterUserCommand $command): void
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

        $this->saveRepository->save($user);
    }
}
