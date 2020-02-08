<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Doctrine\Repository;

use App\Domain\Entity\Job;
use App\Domain\Entity\User;
use App\Domain\Repository\Job\JobByUserFinder;
use App\Domain\Repository\Job\JobDeleter;
use App\Domain\Repository\Job\JobFinder;
use App\Domain\Repository\Job\JobSaver;
use App\Domain\Repository\Job\JobUpdater;
use App\Domain\ValueObject\Uuid;
use Doctrine\ORM\EntityManagerInterface;

class JobRepository extends Repository implements
    JobFinder,
    JobByUserFinder,
    JobSaver,
    JobUpdater,
    JobDeleter
{
    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct($entityManager, Job::class);
    }

    public function find(Uuid $uuid): ?Job
    {
        return $this->findOneBy(['uuid' => $uuid]);
    }

    public function findOneBy(array $conditions): ?Job
    {
        return $this->repository->findOneBy($conditions);
    }

    public function findOneByUser(string $jobUuid, User $user): ?Job
    {
        return $this->repository->findOneBy(
            [
                'uuid' => $jobUuid,
                'user' => $user->getId()
            ]
        );
    }

    public function save(Job $job): void
    {
        $this->entityManager->persist($job);
        $this->completeTransaction();
    }

    public function update(Job $job): void
    {
        $this->completeTransaction();
    }

    public function delete(Job $job): void
    {
        $this->entityManager->remove($job);
        $this->completeTransaction();
    }

    public function completeTransaction(): void
    {
        $this->entityManager->flush();
    }
}
