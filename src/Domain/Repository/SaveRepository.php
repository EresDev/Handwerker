<?php

namespace App\Domain\Repository;

use App\Domain\Entity\Entity;

interface SaveRepository
{
    public function save(Entity $entity): void;
}
