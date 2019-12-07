<?php

namespace App\Domain\Repository;

use App\Domain\Entity\Entity;

interface ReadRepository
{
    public function get(int $entityId, string $entityClass): ?Entity;

    public function getBy(string $key, $value, string $entityClass): ?Entity;
}
