<?php

declare(strict_types=1);

namespace App\Application\QueryHandler;

use App\Application\Query\GetJobQuery;
use App\Domain\Entity\Job;
use App\Domain\Repository\Job\JobByUserFinder;

class GetJobHandler
{
    private JobByUserFinder $jobByUserFinder;

    public function __construct(JobByUserFinder $jobByUserFinder)
    {
        $this->jobByUserFinder = $jobByUserFinder;
    }

    public function handle(GetJobQuery $query): ?Job
    {
        return $this->jobByUserFinder->findOneByUser(
            $query->getUuid(),
            $query->getUser()
        );
    }
}
