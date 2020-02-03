<?php

declare(strict_types=1);

namespace App\Tests\Unit\Application\CommandHandler;

use App\Application\Command\DeleteJobCommand;
use App\Application\CommandHandler\DeleteJobHandler;
use App\Application\Service\Validator;
use App\Domain\Exception\TempValidationException;
use App\Domain\Repository\Job\JobByUserFinder;
use App\Domain\Repository\Job\JobDeleter;
use App\Tests\Shared\Fixture\JobFixture;
use App\Tests\Shared\Fixture\UserFixture;
use App\Tests\Shared\KernelTestCase;
use App\Tests\Shared\TestData;
use PHPUnit\Framework\MockObject\MockObject;

class DeleteJobHandlerTest extends KernelTestCase
{
    private Validator $validator;
    private MockObject $jobByUserFinder;
    private MockObject $jobDeleter;

    protected function setUp(): void
    {
        static::bootKernel();

        $this->validator = $this->getService(Validator::class);
        $this->jobDeleter =
            $this->createMock(JobDeleter::class);

        $this->jobByUserFinder = $this->createMock(JobByUserFinder::class);
        $this->jobByUserFinder
            ->method('findOneByUser')
            ->willReturn(JobFixture::getInstance());
    }

    public function testHandleRequestWithValidAndExistingJobUuid(): void
    {
        $this->jobDeleter
            ->expects($this->atLeast(1))
            ->method('delete');

        $command = new DeleteJobCommand(JobFixture::UUID, UserFixture::getInstance());

        $handler = new DeleteJobHandler(
            $this->validator,
            $this->jobByUserFinder,
            $this->jobDeleter
        );

        $handler->handle($command);
    }

    /**
     * @dataProvider invalidUuidValuesDataProvider
     */
    public function testHandleRequestWithJobUuidAsAnEmptyString(TestData $testData): void
    {
        $command = new DeleteJobCommand($testData->getInput(), UserFixture::getInstance());

        $handler = new DeleteJobHandler(
            $this->validator,
            $this->jobByUserFinder,
            $this->jobDeleter
        );

        $this->expectException(TempValidationException::class);

        try {
            $handler->handle($command);
        } catch (TempValidationException $exception) {
            $errors = $exception->getViolations();
            $this->assertArrayHasKey(
                $testData->getExpectedValue(),
                $errors,
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
