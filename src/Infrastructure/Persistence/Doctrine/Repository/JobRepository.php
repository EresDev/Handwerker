<?php

namespace App\Infrastructure\Persistence\Doctrine\Repository;

use App\Domain\Entity\Job;
use App\Domain\Repository\Job\JobSaver;
use Doctrine\ORM\EntityManagerInterface;

class JobRepository extends Repository implements JobSaver
{
    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct($entityManager, Job::class);
    }

    public function save(Job $job): void
    {
        $this->entityManager->persist($job);
        $this->completeTransaction();
    }

    public function completeTransaction(): void
    {
        $this->entityManager->flush();
    }
}
