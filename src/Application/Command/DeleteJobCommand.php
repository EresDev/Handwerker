<?php

declare(strict_types=1);

namespace App\Application\Command;

use App\Domain\Entity\User;
use App\Domain\ValueObject\Uuid;

class DeleteJobCommand
{
    private Uuid $uuid;
    private User $user;

    public function __construct(Uuid $uuid, User $user)
    {
        $this->uuid = $uuid;
        $this->user = $user;
    }

    public function getUuid(): Uuid
    {
        return $this->uuid;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function __toString(): string
    {
        return print_r(
            [
                'uuid' => $this->uuid->getValue(),
                'userId' => $this->user->getUuid()->getValue()
            ],
            true
        );
    }
}
