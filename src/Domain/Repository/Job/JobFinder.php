<?php

declare(strict_types=1);

namespace App\Domain\Repository\Job;

use App\Domain\Entity\Job;
use App\Domain\ValueObject\Uuid;

interface JobFinder
{
    public function find(Uuid $uuid): ?Job;

    public function findOneBy(array $conditions): ?Job;
}
