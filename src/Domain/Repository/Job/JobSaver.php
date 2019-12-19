<?php

declare(strict_types=1);

namespace App\Domain\Repository\Job;

use App\Domain\Entity\Job;

interface JobSaver
{
    public function save(Job $job): void;
}
