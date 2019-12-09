<?php

namespace App\Domain\Repository\User;

use App\Domain\Entity\User;

interface UserUpdater
{
    public function update(User $user): void;
}
