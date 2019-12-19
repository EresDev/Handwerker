<?php

declare(strict_types=1);

namespace App\Application\Service\Factory;

use App\Application\Command\CreateJobCommand;
use App\Domain\Entity\Job;
use App\Domain\Exception\ValidationException;

interface JobFactory
{
    /**
     * @throws ValidationException
     */
    public function create(CreateJobCommand $command): Job;
}
