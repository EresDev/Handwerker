<?php

namespace App\ThirdParty\Persistence\Doctrine\Repository;

use App\Domain\Entity\User;

class UserRepository extends AbstractRepository
{
    public function getEntityClass(): string
    {
        return User::class;
    }
}
