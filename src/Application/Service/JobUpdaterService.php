<?php

declare(strict_types=1);

namespace App\Application\Service;

use App\Domain\Entity\Job;
use App\Domain\Exception\ValidationException;
use App\Domain\Repository\Category\CategoryFinder;
use App\Domain\Repository\Job\JobFinder;
use App\Application\Command\UpdateJobCommand;

class JobUpdaterService
{
    private JobFinder $jobFinder;
    private CategoryFinder $categoryFinder;

    public function __construct(JobFinder $jobFinder, CategoryFinder $categoryFinder)
    {
        $this->jobFinder = $jobFinder;
        $this->categoryFinder = $categoryFinder;
    }

    public function getUpdated(UpdateJobCommand $command): Job
    {
        $job = $this->jobFinder->find($command->getUuid());

        if (!$job) {
            throw new ValidationException([['uuid' => 'No such job exists to update.']]);
        }

        if ($job->getCategory()->getUuid() !== $command->getCategoryId()) {
            $category = $this->categoryFinder->findOneBy('uuid', $command->getCategoryId());
            if (!$category) {
                throw new ValidationException([['categoryId' => 'Given category does not exist.']]);
            }
            $job->setCategory($category);
        }

        $job->setTitle($command->getTitle());
        $job->setZipCode($command->getZipCode());
        $job->setCity($command->getCity());
        $job->setDescription($command->getDescription());
        $job->setExecutionDateTime($command->getExecutionDateTime());

        return $job;
    }
}
