<?php

namespace App\Usecase;

use App\Domain\Entity\Role;
use App\Domain\Entity\User;
use App\Domain\Exception\ValidationException;
use App\Domain\Repository\RelationalSaverRepository;
use App\Domain\Service\PasswordEncoder;
use App\Domain\Service\Validator;
use App\Domain\ValueObject\ValidatorResponse;
use App\Usecase\Command\RegisterUserCommand;

class RegisterUserHandler
{
    private PasswordEncoder $passwordEncoder;
    private Validator $validator;
    private RelationalSaverRepository $relationalSaverRepository;

    public function __construct(
        PasswordEncoder $passwordEncoder,
        Validator $validator,
        RelationalSaverRepository $relationalSaverRepository
    ) {
        $this->passwordEncoder = $passwordEncoder;
        $this->validator = $validator;
        $this->relationalSaverRepository = $relationalSaverRepository;
    }

    public function handle(RegisterUserCommand $command): void
    {
        $validatorResponse = $this->validator->validate($command);
        if (!$validatorResponse->isValid()) {
            $errors = $validatorResponse->getErrors();

            throw new ValidationException(
                $errors,
                sprintf(
                    "Validation failed for %s \nGiven Object: %s\nValidation errors are: \n%s",
                    RegisterUserCommand::class,
                    $command,
                    json_encode($validatorResponse->getErrors())
                )
            );
        }

        $user = new User();
        $user->setUuid($command->getUuid());
        $user->setEmail($command->getEmail());

        $encodedPassword = $this->passwordEncoder->encode(
            $command->getPassword(),
            $user->getSalt()
        );

        $user->setPassword($encodedPassword);

        $role = $this->relationalSaverRepository->getBy(
            'title',
            'USER',
            Role::class
        );
        $user->setRoles([$role]);

        $this->relationalSaverRepository->save($user);
    }
}
