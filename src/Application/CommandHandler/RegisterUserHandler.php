<?php

declare(strict_types=1);

namespace App\Application\CommandHandler;

use App\Application\Command\RegisterUserCommand;
use App\Application\Service\Factory\UserFactory;
use App\Application\Service\Validator;
use App\Domain\Repository\User\UserSaver;

class RegisterUserHandler
{
    private Validator $validator;
    private UserSaver $userSaver;
    private UserFactory $userFactory;

    public function __construct(
        Validator $validator,
        UserSaver $userSaver,
        UserFactory $userFactory
    ) {
        $this->validator = $validator;
        $this->userSaver = $userSaver;
        $this->userFactory = $userFactory;
    }

    public function handle(RegisterUserCommand $command): void
    {
        $this->validator->validate($command);

        $user = $this->userFactory->create($command);

        $this->userSaver->save($user);
    }
}
