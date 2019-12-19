<?php

declare(strict_types=1);

namespace App\Tests\Unit\Application\CommandHandler;

use App\Application\Command\CreateJobCommand;
use App\Application\CommandHandler\CreateJobHandler;
use App\Application\Service\Association\AssociatedEntityCreator;
use App\Application\Service\Uuid;
use App\Application\Service\Validator;
use App\Domain\Exception\ValidationException;
use App\Domain\Repository\Job\JobSaver;
use App\Tests\Shared\KernelTestCase;
use App\Tests\Shared\ObjectMother\JobMother;
use App\Tests\Shared\TestData;

class CreateJobHandlerTest extends KernelTestCase
{
    private Validator $validator;
    private JobSaver $jobSaver;
    private Uuid $uuidGenerator;
    private AssociatedEntityCreator $associatedEntityCreator;

    protected function setUp(): void
    {
        static::bootKernel();

        $this->validator = $this->getService(Validator::class);
        $this->jobSaver =
            $this->createMock(JobSaver::class);
        $this->uuidGenerator = $this->getService(Uuid::class);
        $this->associatedEntityCreator = $this->getService(AssociatedEntityCreator::class);
    }

    public function testHandleWithValidData(): void
    {
        $this->jobSaver
            ->expects($this->once())
            ->method('save');

        $validData = JobMother::toValidParameterArray(false);

        $command = $this->getCommandFrom($validData);

        $handler = new CreateJobHandler(
            $this->validator,
            $this->jobSaver,
            $this->associatedEntityCreator
        );

        $handler->handle($command);
    }

    private function getCommandFrom(array $commandAttrs): CreateJobCommand
    {
        return new CreateJobCommand(
            $this->uuidGenerator->generate(),
            $commandAttrs['title'],
            $commandAttrs['zipCode'],
            $commandAttrs['city'],
            $commandAttrs['description'],
            $commandAttrs['executionDateTime'],
            $commandAttrs['categoryId'],
            '3e279073-ca26-41d8-94e8-002e9dc36f9b'
        );
    }

    /**
     * @dataProvider getInvalidValues
     */
    public function testHandleForInvalidValues(TestData $testData): void
    {
        $command = $this->getCommandFrom($testData->getInput());

        $handler = new CreateJobHandler(
            $this->validator,
            $this->jobSaver,
            $this->associatedEntityCreator
        );

        $this->expectException(ValidationException::class);

        try {
            $handler->handle($command);
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

    public function getInvalidValues(): array
    {
        return [
            [
                new TestData(
                    $this->prepareTestDataForInvalidJob('title', ''),
                    'title',
                    'Validation error: ' .
                    'Given empty title ' .
                    'but did not get back title validation error'
                )
            ],
            [
                new TestData(
                    $this->prepareTestDataForInvalidJob(
                        'executionDateTime',
                        $this->getExecutionDateTime23HoursFromNow()
                    ),
                    'executionDateTime',
                    'Validation error: ' .
                    'Given executionDateTime before 24 hours ' .
                    'but did not get back executionDateTime validation error'
                )
            ],
            [
                new TestData(
                    $this->prepareTestDataForInvalidJob('zipCode', ''),
                    'zipCode',
                    'Validation error: ' .
                    'Given empty zipCode ' .
                    'but did not get back zipCode validation error'
                )
            ],
            [
                new TestData(
                    $this->prepareTestDataForInvalidJob('zipCode', '121212'),
                    'zipCode',
                    'Validation error: ' .
                    'Given 6 chars zipCode ' .
                    'but did not get back zipCode validation error ' .
                    'Expected 5 chars zipCode'
                )
            ],
            [
                new TestData(
                    $this->prepareTestDataForInvalidJob('zipCode', '1212'),
                    'zipCode',
                    'Validation error: ' .
                    'Given 4 chars zipCode ' .
                    'but did not get back zipCode validation error ' .
                    'Expected 5 chars zipCode'
                )
            ],
            [
                new TestData(
                    $this->prepareTestDataForInvalidJob('city', ''),
                    'city',
                    'Validation error: ' .
                    'Given empty city ' .
                    'but did not get back city validation error'
                )
            ],
            [
                new TestData(
                    $this->prepareTestDataForInvalidJob('city', 'ab'),
                    'city',
                    'Validation error: ' .
                    'Given too short city ' .
                    'but did not get back city validation error'
                )
            ],
            [
                new TestData(
                    $this->prepareTestDataForInvalidJob(
                        'city',
                        str_repeat('a', 51)
                    ),
                    'city',
                    'Validation error: ' .
                    'Given too long city ' .
                    'but did not get back city validation error'
                )
            ],
            [
                new TestData(
                    $this->prepareTestDataForInvalidJob(
                        'description',
                        str_repeat('a', 251)
                    ),
                    'description',
                    'Validation error: ' .
                    'Given too long description ' .
                    'but did not get back city validation error'
                )
            ],
            [
                new TestData(
                    $this->prepareTestDataForInvalidJob('categoryId', 'fooBar'),
                    'categoryId',
                    'Validation error: ' .
                    'Given invalid format UUID of categoryId ' .
                    'but did not get back city validation error'
                )
            ],
        ];
    }

    private function prepareTestDataForInvalidJob(string $attrToOverride, $attrValue): array
    {
        $testData = JobMother::toValidParameterArray(false);
        $testData[$attrToOverride] = $attrValue;

        return $testData;
    }

    public function getExecutionDateTime23HoursFromNow(): \DateTime
    {
        return (new \DateTime())->modify('+23 hours');
    }
}
