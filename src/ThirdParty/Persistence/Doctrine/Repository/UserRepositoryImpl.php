<?php

namespace App\ThirdParty\Persistence\Doctrine\Repository;

use App\Domain\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use App\Domain\Entity\Entity;
use App\Domain\Repository\SingleEntityFinder;

class UserRepositoryImpl implements SingleEntityFinder
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function findBy(string $key, $value): ?Entity
    {
        return $this->entityManager
            ->getRepository(User::class)
            ->findOneBy([$key => $value]);
    }
}
