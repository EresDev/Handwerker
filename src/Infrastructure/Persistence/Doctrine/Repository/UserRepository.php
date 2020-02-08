<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Doctrine\Repository;

use App\Domain\Entity\User;
use App\Domain\Repository\User\UserDeleter;
use App\Domain\Repository\User\UserFinder;
use App\Domain\Repository\User\UserSaver;
use App\Domain\ValueObject\Uuid;
use Doctrine\ORM\EntityManagerInterface;

class UserRepository extends Repository implements UserFinder, UserSaver, UserDeleter
{
    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct($entityManager, User::class);
    }

    public function find(Uuid $uuid): ?User
    {
        return $this->repository->findOneBy(['uuid' => $uuid]);
    }

    public function findOneBy(string $key, string $value): ?User
    {
        return $this->repository->findOneBy([$key => $value]);
    }

    public function save(User $user): void
    {
        $this->entityManager->persist($user);
        $this->completeTransaction();
    }

    public function delete(User $user): void
    {
        $this->entityManager->remove($user);
        $this->completeTransaction();
    }

    public function completeTransaction(): void
    {
        $this->entityManager->flush();
    }
}
