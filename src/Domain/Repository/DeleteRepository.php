<?php

namespace App\Domain\Repository;

use App\Domain\Entity\Entity;

interface DeleteRepository
{
    public function delete(Entity $entity): void;
}
