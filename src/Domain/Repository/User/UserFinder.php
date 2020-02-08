<?php

declare(strict_types=1);

namespace App\Domain\Repository\User;

use App\Domain\Entity\User;
use App\Domain\ValueObject\Uuid;

interface UserFinder
{
    public function find(Uuid $uuid): ?User;

    public function findOneBy(string $key, string $value): ?User;
}
