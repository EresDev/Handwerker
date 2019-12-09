<?php

namespace App\Infrastructure\Persistence\Doctrine\Repository;

use App\Domain\Entity\User;
use App\Domain\Repository\User\UserFinder;
use App\Domain\Repository\User\UserSaver;
use Doctrine\ORM\EntityManagerInterface;

class UserRepository extends Repository implements UserFinder, UserSaver
{
    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct($entityManager, User::class);
    }

    public function find(int $id): User
    {
        return $this->repository->find($id);
    }

    public function save(User $user): void
    {
        $this->entityManager->persist($user);
        $this->completeTransaction();
    }


    public function completeTransaction(): void
    {
        $this->entityManager->flush();
    }
}
