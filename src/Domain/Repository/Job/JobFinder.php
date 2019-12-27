<?php

declare(strict_types=1);

namespace App\Domain\Repository\Job;

use App\Domain\Entity\Job;

interface JobFinder
{
    public function find(string $uuid): ?Job;

    public function findOneBy(array $conditions): ?Job;
}
