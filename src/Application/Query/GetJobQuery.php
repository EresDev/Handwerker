<?php

declare(strict_types=1);

namespace App\Application\Query;

use App\Domain\Entity\User;

class GetJobQuery
{
    private string $uuid;
    private User $user;

    public function __construct(string $uuid, User $user)
    {
        $this->uuid = $uuid;
        $this->user = $user;
    }

    public function getUuid(): string
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
                'uuid' => $this->uuid,
                'userId' => $this->user->getUuid()
            ],
            true
        );
    }
}
