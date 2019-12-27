<?php

declare(strict_types=1);

namespace App\Application\QueryHandler;

use App\Application\Query\GetJobQuery;
use App\Application\Service\Validator;
use App\Domain\Entity\Job;
use App\Domain\Repository\Job\JobByUserFinder;

class GetJobHandler
{
    private Validator $validator;
    private JobByUserFinder $jobByUserFinder;

    public function __construct(Validator $validator, JobByUserFinder $jobByUserFinder)
    {
        $this->validator = $validator;
        $this->jobByUserFinder = $jobByUserFinder;
    }

    public function handle(GetJobQuery $query): ?Job
    {
        $this->validator->validate($query);

        return $this->jobByUserFinder->findOneByUser(
            $query->getUuid(),
            $query->getUser()
        );
    }
}
