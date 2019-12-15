<?php

namespace App\Application\CommandHandler;

use App\Application\Command\CreateJobCommand;
use App\Application\Service\Association\AssociatedEntityCreator;
use App\Application\Service\Validator;
use App\Domain\Entity\Job;
use App\Domain\Repository\Category\CategoryFinder;
use App\Domain\Repository\Job\JobSaver;
use App\Domain\Repository\User\UserFinder;

class CreateJobHandler
{
    private Validator $validator;
    private JobSaver $jobSaver;
    private AssociatedEntityCreator $associatedEntityCreator;

    public function __construct(
        Validator $validator,
        JobSaver $jobSaver,
        AssociatedEntityCreator $associatedEntityCreator
    ) {
        $this->validator = $validator;
        $this->jobSaver = $jobSaver;
        $this->associatedEntityCreator = $associatedEntityCreator;
    }

    public function handle(CreateJobCommand $command): void
    {
        $this->validator->validate($command);

        $job = $this->associatedEntityCreator->create($command);

        $this->jobSaver->save($job);
    }
}
