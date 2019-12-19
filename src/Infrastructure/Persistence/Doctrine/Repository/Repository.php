<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Doctrine\Repository;

use Doctrine\Common\Persistence\ObjectRepository;
use Doctrine\ORM\EntityManagerInterface;

abstract class Repository
{
    protected EntityManagerInterface $entityManager;
    protected ObjectRepository $repository;

    public function __construct(EntityManagerInterface $entityManager, string $entityClass)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository($entityClass);
    }
}
