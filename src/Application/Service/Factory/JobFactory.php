<?php

declare(strict_types=1);

namespace App\Application\Service\Factory;

use App\Application\Command\CreateJobCommand;
use App\Domain\Entity\Job;
use App\Domain\Exception\DomainException;

interface JobFactory
{
    /**
     * @throws DomainException
     */
    public function create(CreateJobCommand $command): Job;
}
