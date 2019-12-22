<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Doctrine\Repository;

use App\Domain\Entity\Job;
use App\Domain\Repository\Job\JobFinder;
use App\Domain\Repository\Job\JobSaver;
use App\Domain\Repository\Job\JobUpdater;
use Doctrine\ORM\EntityManagerInterface;

class JobRepository extends Repository implements JobFinder, JobSaver, JobUpdater
{
    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct($entityManager, Job::class);
    }

    public function find(string $uuid): ?Job
    {
        return $this->findOneBy('uuid', $uuid);
    }

    public function findOneBy(string $key, string $value): ?Job
    {
        return $this->repository->findOneBy([$key => $value]);
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

    public function completeTransaction(): void
    {
        $this->entityManager->flush();
    }
}
