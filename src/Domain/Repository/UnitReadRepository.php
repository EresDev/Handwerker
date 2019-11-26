<?php

namespace App\Domain\Repository;

interface UnitReadRepository
{
    public function get(int $entityId): ?Entity;
}
