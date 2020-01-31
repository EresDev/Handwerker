<?php

declare(strict_types=1);

namespace App\Application\Service\Factory;

use App\Application\Command\CreateJobCommand;
use App\Domain\Entity\Job;
use App\Domain\Exception\DomainException;
use App\Domain\Repository\Category\CategoryFinder;
use App\Domain\Repository\User\UserFinder;

class JobFactoryImpl implements JobFactory
{
    private CategoryFinder $categoryFinder;
    private UserFinder $userFinder;

    public function __construct(
        CategoryFinder $categoryFinder,
        UserFinder $userFinder
    ) {
        $this->categoryFinder = $categoryFinder;
        $this->userFinder = $userFinder;
    }

    /**
     * @throw DomainException
     */
    public function create(CreateJobCommand $command): Job
    {
        $category = $this->categoryFinder->findOneBy('uuid', $command->getCategoryId());
        if (!$category) {
            throw DomainException::fromMessages(
                ['categoryId' => 'Provided category for the job does not exist.']
            );
        }

        $job = new Job(
            $command->getUuid(),
            $command->getTitle(),
            $command->getZipCode(),
            $command->getCity(),
            $command->getDescription(),
            $command->getExecutionDateTime(),
            $category,
            $command->getUser()
        );

        return $job;
    }
}
