<?php

declare(strict_types=1);

namespace App\Application\CommandHandler;

use App\Application\Command\UpdateJobCommand;
use App\Application\Service\JobUpdaterService;
use App\Application\Service\Validator;
use App\Domain\Repository\Job\JobUpdater;

class UpdateJobHandler
{
    private Validator $validator;
    private JobUpdater $jobUpdater;
    private JobUpdaterService $jobUpdaterService;

    public function __construct(Validator $validator, JobUpdater $jobUpdater, JobUpdaterService $jobUpdaterService)
    {
        $this->validator = $validator;
        $this->jobUpdater = $jobUpdater;
        $this->jobUpdaterService = $jobUpdaterService;
    }

    public function handle(UpdateJobCommand $command): void
    {
        $this->validator->validate($command);

        $job = $this->jobUpdaterService->getUpdated($command);

        $this->jobUpdater->update($job);
    }
}
