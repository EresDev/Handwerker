<?php

namespace App\Domain\Repository\Generic;

use App\Domain\Entity\Entity;

interface EntityFinder
{
    public function find(int $id): Entity;
}
