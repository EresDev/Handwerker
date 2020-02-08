<?php

declare(strict_types=1);

namespace App\Application\CommandHandler;

use App\Application\Command\DeleteJobCommand;
use App\Domain\Exception\DomainException;
use App\Domain\Exception\ValidationException;
use App\Domain\Repository\Job\JobByUserFinder;
use App\Domain\Repository\Job\JobDeleter;

class DeleteJobHandler
{
    private JobDeleter $jobDeleter;
    private JobByUserFinder $joByUserFinder;

    public function __construct(
        JobByUserFinder $jobByUserFinder,
        JobDeleter $jobDeleter
    ) {
        $this->jobDeleter = $jobDeleter;
        $this->joByUserFinder = $jobByUserFinder;
    }

    /**
     * @throws ValidationException
     */
    public function handle(DeleteJobCommand $command): void
    {
        $job = $this->joByUserFinder->findOneByUser(
            $command->getUuid(),
            $command->getUser()
        );

        if (!$job) {
            throw DomainException::from(
                'Requested job was not found. Delete operation failed.'
            );
        }

        $this->jobDeleter->delete($job);
    }
}
