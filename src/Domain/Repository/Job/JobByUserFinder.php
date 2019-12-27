<?php

declare(strict_types=1);

namespace App\Domain\Repository\Job;

use App\Domain\Entity\Job;
use App\Domain\Entity\User;

interface JobByUserFinder
{
    public function findOneByUser(string $jobUuid, User $user): ?Job;
}
