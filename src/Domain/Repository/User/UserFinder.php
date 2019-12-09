<?php

namespace App\Domain\Repository\User;

use App\Domain\Entity\User;

interface UserFinder
{
    public function find(int $id) : User;
}
