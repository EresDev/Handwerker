<?php

namespace App\Domain\Repository\User;

use App\Domain\Entity\User;

interface UserDeleter
{
    public function delete(User $user): void;
}
