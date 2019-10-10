<?php

namespace App\Domain\Repository;

use App\Domain\Entity\Entity;

interface SingleEntityFinder
{
    public function findBy(string $key, $value): ?Entity;
}
