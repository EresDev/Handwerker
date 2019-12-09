<?php

namespace App\Domain\Repository\Note;

use App\Domain\Entity\Note;

interface NoteFinder
{
    public function find(int $id): Note;
}
