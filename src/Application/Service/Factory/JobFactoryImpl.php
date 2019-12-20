<?php

declare(strict_types=1);

namespace App\Application\Service\Factory;

use App\Application\Command\CreateJobCommand;
use App\Domain\Entity\Job;
use App\Domain\Exception\ValidationException;
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
     * @throw Exception
     */
    public function create(CreateJobCommand $command): Job
    {
        $category = $this->categoryFinder->findOneBy('uuid', $command->getCategoryId());
        if (!$category) {
            throw new ValidationException([['categoryId' => '"Provided category is not found."']]);
        }

        $user = $this->userFinder->findOneBy('uuid', $command->getUserId());
        if (!$user) {
            throw new ValidationException([['userId' => '"Provided user is not found."']]);
        }

        $job = new Job(
            $command->getUuid(),
            $command->getTitle(),
            $command->getZipCode(),
            $command->getCity(),
            $command->getDescription(),
            $command->getExecutionDateTime(),
            $category,
            $user
        );

        return $job;
    }
}