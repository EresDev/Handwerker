<?php

namespace App\Domain\Repository\Category;

use App\Domain\Entity\Category;

interface CategoryFinder
{
    public function find(int $id): ?Category;
    public function findOneBy(string $key, string $value): ?Category;
}
