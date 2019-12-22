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
            throw ValidationException::fromSingleViolation(
                'categoryId',
                'Provided category for new job does not exist.'
            );
        }

        $user = $this->userFinder->findOneBy('uuid', $command->getUserId());
        if (!$user) {
            throw ValidationException::fromSingleViolation(
                'userId',
                'Provided user is not found.'
            )
                ->withDebugInfo(
                    sprintf(
                        "Job creation is not accessible to unauthorized users, " .
                        "and the user does not exist in database." .
                        "\nGiven class %s, object %s",
                        CreateJobCommand::class,
                        $command
                    )
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
            $user
        );

        return $job;
    }
}
