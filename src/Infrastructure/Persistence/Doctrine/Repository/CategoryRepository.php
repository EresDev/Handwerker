<?php

namespace App\Infrastructure\Persistence\Doctrine\Repository;

use App\Domain\Entity\Category;
use App\Domain\Repository\Category\CategoryFinder;
use Doctrine\ORM\EntityManagerInterface;

class CategoryRepository extends Repository implements CategoryFinder
{
    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct($entityManager, Category::class);
    }

    public function find(int $id): ?Category
    {
        return $this->repository->find($id);
    }

    public function findOneBy(string $key, string $value): ?Category
    {
        return $this->repository->findOneBy([$key => $value]);
    }
}
