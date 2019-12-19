<?php

declare(strict_types=1);

namespace App\Domain\Repository\User;

use App\Domain\Entity\User;

interface UserDeleter
{
    public function delete(User $user): void;
}
