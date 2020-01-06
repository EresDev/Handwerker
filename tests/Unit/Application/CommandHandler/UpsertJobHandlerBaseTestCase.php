<?php

declare(strict_types=1);

namespace App\Tests\Unit\Application\CommandHandler;

use App\Domain\Exception\ValidationException;
use App\Tests\Shared\KernelTestCase;
use App\Tests\Shared\ObjectMother\JobMother;
use App\Tests\Shared\TestData;
use DateTime;

abstract class UpsertJobHandlerBaseTestCase extends KernelTestCase
{
    /**
     * @dataProvider invalidValuesDataProvider
     */
    public function testHandleForInvalidValues(TestData $testData): void
    {
        $command = $this->getCommandFrom($testData->getInput());

        $handler = $this->getHandlerInstance();

        $this->expectException(ValidationException::class);

        try {
            $handler->handle($command);
        } catch (ValidationException $exception) {
            $errors = $exception->getMessagesForEndUser();
            $this->assertArrayHasKey(
                $testData->getExpectedValue(),
                $errors,
                $testData->getTestFailureReason()
            );

            $this->assertCount(1, $errors);
            throw $exception;
        }
    }

    public function invalidValuesDataProvider(): array
    {
        return [
            'Blank title validation error' => [
                new TestData(
                    $this->prepareTestDataForInvalidJob('title', ''),
                    'title',
                    'Validation error: ' .
                    'Given empty title ' .
                    'but did not get back title validation error'
                )
            ],
            'Execution datetime before 24 hours validation error' => [
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
            'Blank zip code validation error' => [
                new TestData(
                    $this->prepareTestDataForInvalidJob('zipCode', ''),
                    'zipCode',
                    'Validation error: ' .
                    'Given empty zipCode ' .
                    'but did not get back zipCode validation error'
                )
            ],
            '6 digit zip code validation error' => [
                new TestData(
                    $this->prepareTestDataForInvalidJob('zipCode', '121212'),
                    'zipCode',
                    'Validation error: ' .
                    'Given 6 chars zipCode ' .
                    'but did not get back zipCode validation error ' .
                    'Expected 5 chars zipCode'
                )
            ],
            '4 digit zip code validation error' => [
                new TestData(
                    $this->prepareTestDataForInvalidJob('zipCode', '1212'),
                    'zipCode',
                    'Validation error: ' .
                    'Given 4 chars zipCode ' .
                    'but did not get back zipCode validation error ' .
                    'Expected 5 chars zipCode'
                )
            ],
            'Blank city validation error' => [
                new TestData(
                    $this->prepareTestDataForInvalidJob('city', ''),
                    'city',
                    'Validation error: ' .
                    'Given empty city ' .
                    'but did not get back city validation error'
                )
            ],
            'Too short city name validation error validation error' => [
                new TestData(
                    $this->prepareTestDataForInvalidJob('city', 'ab'),
                    'city',
                    'Validation error: ' .
                    'Given too short city ' .
                    'but did not get back city validation error'
                )
            ],
            'Too long city name validation error' => [
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
            'Too long description validation error' => [
                new TestData(
                    $this->prepareTestDataForInvalidJob(
                        'description',
                        str_repeat('a', 251)
                    ),
                    'description',
                    'Validation error: ' .
                    'Given too long description ' .
                    'but did not get back description validation error'
                )
            ],
            'Invalid format of UUID categoryId validation error' => [
                new TestData(
                    $this->prepareTestDataForInvalidJob('categoryId', 'fooBar'),
                    'categoryId',
                    'Validation error: ' .
                    'Given invalid format of UUID categoryId ' .
                    'but did not get back categoryId validation error'
                )
            ],
            'Valid UUID categoryId that is not existing in DB validation error' => [
                new TestData(
                    $this->prepareTestDataForInvalidJob('categoryId', '7c17e4eb-51d9-429b-b82b-a73f23c19a4c'),
                    'categoryId',
                    'Validation error: ' .
                    'Given valid UUID categoryId that is not existing in DB ' .
                    'but did not get back categoryId validation error'
                )
            ],
        ];
    }

    abstract protected function getCommandFrom(array $commandAttrs): object;

    abstract protected function getHandlerInstance(): object;

    private function prepareTestDataForInvalidJob(string $attrToOverride, $attrValue): array
    {
        $testData = JobMother::toValidParameterArray(false);
        $testData[$attrToOverride] = $attrValue;

        return $testData;
    }

    private function getExecutionDateTime23HoursFromNow(): DateTime
    {
        return (new DateTime())->modify('+23 hours');
    }
}
