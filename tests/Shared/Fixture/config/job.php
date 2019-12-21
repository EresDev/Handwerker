<?php

declare(strict_types=1);

use App\Domain\Entity\Job;
use App\Tests\Shared\Fixture\JobFixture;

return [
    Job::class => [
        'job_1' => [
            '__construct' => [
                JobFixture::UUID,
                JobFixture::TITLE,
                JobFixture::ZIP_CODE,
                JobFixture::CITY,
                JobFixture::DESCRIPTION,
                JobFixture::getExecutionDateTime(),
                '@category_1',
                '@user_1',
            ],

        ],
    ],
];
