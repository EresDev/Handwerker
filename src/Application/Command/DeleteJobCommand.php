<?php

declare(strict_types=1);

namespace App\Application\Command;

use App\Domain\Entity\User;

class DeleteJobCommand
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
}
