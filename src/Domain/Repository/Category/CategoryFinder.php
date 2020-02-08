<?php

declare(strict_types=1);

namespace App\Domain\Repository\Category;

use App\Domain\Entity\Category;
use App\Domain\ValueObject\Uuid;

interface CategoryFinder
{
    public function find(Uuid $uuid): ?Category;

    public function findOneBy(string $key, string $value): ?Category;
}
