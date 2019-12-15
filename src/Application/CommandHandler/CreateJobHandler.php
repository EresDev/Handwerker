<?php

namespace App\Application\CommandHandler;

use App\Application\Command\CreateJobCommand;
use App\Application\Service\Validator;
use App\Domain\Entity\Job;
use App\Domain\Repository\Job\JobSaver;

class CreateJobHandler
{
    private Validator $validator;
    private JobSaver $jobSaver;

    public function __construct(Validator $validator, JobSaver $jobSaver)
    {
        $this->validator = $validator;
        $this->jobSaver = $jobSaver;
    }

    public function handle(CreateJobCommand $command)
    {
        $this->validator->validate($command);

        $job = new Job(
            $command->getUuid(),
            $command->getTitle(),
            $command->getZipCode(),
            $command->getCity(),
            $command->getDescription(),
            $command->getExecutionDateTime(),
            $command->getCategoryId(),
            $command->getUserId()
        );

        $this->jobSaver->save($job);
    }
}
