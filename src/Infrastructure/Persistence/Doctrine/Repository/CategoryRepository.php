<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Doctrine\Repository;

use App\Domain\Entity\Category;
use App\Domain\Repository\Category\CategoryFinder;
use App\Domain\ValueObject\Uuid;
use Doctrine\ORM\EntityManagerInterface;

class CategoryRepository extends Repository implements CategoryFinder
{
    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct($entityManager, Category::class);
    }

    public function find(Uuid $uuid): ?Category
    {
        return $this->repository->findOneBy(['uuid' => $uuid]);
    }

    public function findOneBy(string $key, string $value): ?Category
    {
        return $this->repository->findOneBy([$key => $value]);
    }
}
