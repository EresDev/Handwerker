<?php

declare(strict_types=1);

namespace App\Application\CommandHandler;

use App\Application\Command\DeleteJobCommand;
use App\Application\Service\Validator;
use App\Domain\Exception\TempDomainException;
use App\Domain\Exception\ValidationException;
use App\Domain\Repository\Job\JobByUserFinder;
use App\Domain\Repository\Job\JobDeleter;

class DeleteJobHandler
{
    private Validator $validator;
    private JobDeleter $jobDeleter;
    private JobByUserFinder $joByUserFinder;

    public function __construct(
        Validator $validator,
        JobByUserFinder $jobByUserFinder,
        JobDeleter $jobDeleter
    ) {
        $this->validator = $validator;
        $this->jobDeleter = $jobDeleter;
        $this->joByUserFinder = $jobByUserFinder;
    }

    /**
     * @throws ValidationException
     */
    public function handle(DeleteJobCommand $command): void
    {
        $this->validator->validate($command);

        $job = $this->joByUserFinder->findOneByUser(
            $command->getUuid(),
            $command->getUser()
        );

        if (!$job) {
            throw TempDomainException::from(
                'Requested job was not found. Delete operation failed.'
            );
        }

        $this->jobDeleter->delete($job);
    }
}
