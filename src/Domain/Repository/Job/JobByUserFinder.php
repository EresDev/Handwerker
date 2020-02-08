<?php

declare(strict_types=1);

namespace App\Domain\Repository\Job;

use App\Domain\Entity\Job;
use App\Domain\Entity\User;
use App\Domain\ValueObject\Uuid;

interface JobByUserFinder
{
    public function findOneByUser(Uuid $jobUuid, User $user): ?Job;
}
