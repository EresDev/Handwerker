<?php

declare(strict_types=1);

namespace App\Tests\Unit\Application\QueryHandler;

use App\Application\Query\GetJobQuery;
use App\Application\QueryHandler\GetJobHandler;
use App\Domain\Entity\Job;
use App\Domain\Entity\User;
use App\Domain\Repository\Job\JobByUserFinder;
use App\Domain\ValueObject\Uuid;
use App\Tests\Shared\Fixture\JobFixture;
use App\Tests\Shared\Fixture\UserFixture;
use App\Tests\Shared\KernelTestCase;

class GetJobHandlerTest extends KernelTestCase
{
    private JobByUserFinder $jobByUserFinder;

    protected function setUp(): void
    {
        self::bootKernel();

        $this->jobByUserFinder = $this->createMock(JobByUserFinder::class);
    }

    public function testHandleRequestWithValidQuery(): void
    {
        $expectedJob = JobFixture::getInstance();

        $this->jobByUserFinder
            ->method('findOneByUser')
            ->willReturn($expectedJob);

        $query = $this->getQuery($expectedJob->getUuid(), $expectedJob->getUser());

        $handler = new GetJobHandler($this->jobByUserFinder);

        /** @var Job $job */
        $job = $handler->handle($query);

        $this->assertNotNull($job);
        $this->assertTrue(
            $job->equals($expectedJob),
            sprintf(
                "Expected Job object is not equal to the one produced by test. " .
                "\nExpected\n %s\nGot\n%s",
                print_r($expectedJob, true),
                print_r($job, true)
            )
        );
    }

    private function getQuery(Uuid $uuid, User $user): GetJobQuery
    {
        return new GetJobQuery($uuid, $user);
    }

    public function testHandleRequestWithQueryForJobThatDoesNotExist(): void
    {
        $this->jobByUserFinder
            ->method('findOneByUser')
            ->willReturn(null);

        $query = $this->getQuery(
            Uuid::create(),
            UserFixture::getInstance()
        );

        $handler = new GetJobHandler($this->jobByUserFinder);

        $job = $handler->handle($query);

        $this->assertNull(
            $job,
            sprintf(
                "Expected the job to be null, but instead received\n%s",
                print_r($job, true)
            )
        );
    }
}
