<?php

namespace App\Domain\Repository;

use App\Domain\Entity\Entity;

interface UnitReadRepository
{
    public function get(int $entityId): ?Entity;

    public function getBy(string $key, $value): ?Entity;
}
