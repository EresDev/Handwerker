<?php

declare(strict_types=1);

namespace App\Domain\Repository\Job;

use App\Domain\Entity\Job;

interface JobUpdater
{
    public function update(Job $job): void;
}
