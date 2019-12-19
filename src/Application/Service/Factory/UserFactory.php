<?php

declare(strict_types=1);

namespace App\Application\Service\Factory;

use App\Application\Command\RegisterUserCommand;
use App\Domain\Entity\User;

interface UserFactory
{
    public function create(RegisterUserCommand $command): User;
}
