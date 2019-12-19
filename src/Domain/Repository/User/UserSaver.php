<?php

declare(strict_types=1);

namespace App\Domain\Repository\User;

use App\Domain\Entity\User;

interface UserSaver
{
    public function save(User $user): void;
}
