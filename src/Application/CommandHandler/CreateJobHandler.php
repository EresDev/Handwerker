<?php

declare(strict_types=1);

namespace App\Application\CommandHandler;

use App\Application\Command\CreateJobCommand;
use App\Application\Service\Factory\JobFactory;
use App\Application\Service\Validator;
use App\Domain\Repository\Job\JobSaver;

class CreateJobHandler
{
    private Validator $validator;
    private JobSaver $jobSaver;
    private JobFactory $jobFactory;

    public function __construct(
        Validator $validator,
        JobSaver $jobSaver,
        JobFactory $jobFactory
    ) {
        $this->validator = $validator;
        $this->jobSaver = $jobSaver;
        $this->jobFactory = $jobFactory;
    }

    public function handle(CreateJobCommand $command): void
    {
        $this->validator->validate($command);

        $job = $this->jobFactory->create($command);

        $this->jobSaver->save($job);
    }
}
