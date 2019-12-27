<?php

declare(strict_types=1);

namespace App\Tests\Unit\Application\QueryHandler;

use App\Application\Query\GetJobQuery;
use App\Application\QueryHandler\GetJobHandler;
use App\Application\Service\Validator;
use App\Domain\Entity\Job;
use App\Domain\Entity\User;
use App\Domain\Exception\ValidationException;
use App\Domain\Repository\Job\JobByUserFinder;
use App\Tests\Shared\Fixture\JobFixture;
use App\Tests\Shared\Fixture\UserFixture;
use App\Tests\Shared\KernelTestCase;
use App\Tests\Shared\TestData;

class GetJobHandlerTest extends KernelTestCase
{
    private Validator $validator;
    private JobByUserFinder $jobByUserFinder;

    protected function setUp(): void
    {
        self::bootKernel();

        $this->validator = $this->getService(Validator::class);
        $this->jobByUserFinder = $this->createMock(JobByUserFinder::class);
    }

    public function testHandleRequestWithValidQuery(): void
    {
        $expectedJob = JobFixture::getInstance();

        $this->jobByUserFinder
            ->method('findOneByUser')
            ->willReturn($expectedJob);

        $query = $this->getQuery($expectedJob->getUuid(), $expectedJob->getUser());

        $handler = new GetJobHandler(
            $this->validator,
            $this->jobByUserFinder
        );

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

    private function getQuery(string $uuid, User $user): GetJobQuery
    {
        return new GetJobQuery($uuid, $user);
    }

    public function testHandleRequestWithQueryForJobThatDoesNotExist(): void
    {
        $this->jobByUserFinder
            ->method('findOneByUser')
            ->willReturn(null);

        $query = $this->getQuery('bcc2aab9-ba14-4634-ac51-d8a6fd7a3c9e', UserFixture::getInstance());

        $handler = new GetJobHandler(
            $this->validator,
            $this->jobByUserFinder
        );

        $job = $handler->handle($query);

        $this->assertNull(
            $job,
            sprintf(
                "Expected the job to be null, but instead received\n%s",
                print_r($job, true)
            )
        );
    }

    /**
     * @dataProvider invalidUuidValuesDataProvider
     */
    public function testHandleRequestWithQueryForJobWithJobUuidAsAnEmptyString(TestData $testData): void
    {
        $query = $this->getQuery($testData->getInput(), UserFixture::getInstance());

        $handler = new GetJobHandler(
            $this->validator,
            $this->jobByUserFinder
        );

        $this->expectException(ValidationException::class);

        try {
            $handler->handle($query);
        } catch (ValidationException $exception) {
            $errors = $exception->getMessagesForEndUser();
            $this->assertArrayHasKey(
                $testData->getExpectedValue(),
                $errors[0],
                $testData->getTestFailureReason()
            );

            $this->assertCount(1, $errors);
            throw $exception;
        }
    }

    public function invalidUuidValuesDataProvider(): array
    {
        return [
            'Invalid Uuid as empty string' => [
                new TestData(
                    '',
                    'uuid',
                    'Validation error: ' .
                    'Given empty uuid ' .
                    'but did not get back uuid blank validation error'
                )
            ],
            'Invalid Uuid as a string foobar' => [
                new TestData(
                    'foobar',
                    'uuid',
                    'Validation error: ' .
                    'Given invalid Uuid as foobar' .
                    'but did not get back invalid uuid validation error'
                )
            ]
        ];
    }
}
