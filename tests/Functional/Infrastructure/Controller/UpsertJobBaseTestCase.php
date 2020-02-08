<?php

declare(strict_types=1);

namespace App\Tests\Functional\Infrastructure\Controller;

use App\Application\Service\Extension\DateTimeExtension;
use App\Tests\Shared\AuthenticatedClientTrait;
use App\Tests\Shared\Functional\Assertion\ValidationErrorsAssertionTrait;
use App\Tests\Shared\WebTestCase;
use Hautelook\AliceBundle\PhpUnit\RefreshDatabaseTrait;

abstract class UpsertJobBaseTestCase extends WebTestCase
{
    use RefreshDatabaseTrait;
    use AuthenticatedClientTrait;
    use ValidationErrorsAssertionTrait;
    private const URI = ['en' => 'job', 'de' => 'arbeit'];

    protected function sendRequest(string $uri, array $parameters): void
    {
        $this->request(
            $this->getRequestMethod(),
            '/' . $uri,
            $parameters,
            [],
            []
        );
    }

    public function uriProvider(): array
    {
        return [
            'EN URI' => [self::URI['en']],
            'DE URI' => [self::URI['de']]
        ];
    }

    abstract protected function getJobParameters(): array;

    abstract protected function getRequestMethod(): string;

    /**
     * @dataProvider unauthenticatedTestDataProvider
     */
    public function testHandleRequestForValidDataUnauthenticated(string $uri, string $locale): void
    {
        $this->sendRequest(
            $uri,
            $this->getJobParameters()
        );

        $this->assertForUnauthenticatedUser($locale);
    }

    public function unauthenticatedTestDataProvider(): array
    {
        //TODO: add translation for this error message
        return [
            'EN: Unauthenticated Error' => [self::URI['en'], 'en'],
            'DE: Unauthenticated Error' => [self::URI['de'], 'de']
        ];
    }

    /**
     * @dataProvider invalidExecutionDateTimeDataProvider
     */
    public function testHandleRequestForInvalidExecutionDateTimeAsEmptyString(
        string $uri,
        string $expectedError
    ): void {
        $this->authenticateClient();

        $jobParameters = $this->getJobParameters();
        $jobParameters['executionDateTime'] = '';

        $this->sendRequest($uri, $jobParameters);

        $this->assertForError(
            $this->response(),
            ['status' => 'fail', 'data' => ['executionDateTime' => $expectedError]],
            'executionDateTime'
        );
    }

    public function invalidExecutionDateTimeDataProvider(): array
    {
        return [
            'EN: Invalid execution datetime' => [
                self::URI['en'],
                'The execution DateTime must be after 24 hours from now.'
            ],
            'DE: Invalid execution datetime' => [
                self::URI['de'],
                'Die Ausführung von DateTime muss nach 24 Stunden erfolgen.'
            ]
        ];
    }

    /**
     * @dataProvider invalidExecutionDateTimeDataProvider
     */
    public function testHandleRequestForInvalidExecutionDateTimeAsNegativeInteger(
        string $uri,
        string $expectedError
    ): void {
        $this->authenticateClient();
        $jobParameters = $this->getJobParameters();
        $timestampNow = (new DateTimeExtension())
            ->modify('+2 days')
            ->getTimestamp();
        $jobParameters['executionDateTime'] = -$timestampNow;

        $this->sendRequest($uri, $jobParameters);

        $this->assertForError(
            $this->response(),
            ['status' => 'fail', 'data' => ['executionDateTime' => $expectedError]],
            'executionDateTime'
        );
    }

    /**
     * @dataProvider validCategoryUuidThatDoesNotExistDataProvider
     */
    public function testHandleRequestWithValidCategoryUuidThatDoesNotExist(
        string $uri,
        string $expectedError
    ): void {
        $this->authenticateClient();

        $jobParameters = $this->getJobParameters();
        $jobParameters['categoryId'] = 'd2b00dae-905b-4c19-9c26-d530874a4910';

        $this->sendRequest($uri, $jobParameters);

        $this->assertForError(
            $this->response(),
            ['status' => 'error', 'message' => $expectedError],
            'categoryId'
        );
    }

    public function validCategoryUuidThatDoesNotExistDataProvider(): array
    {
        return [
            'EN: Valid Category UUID that does not exist in DB' => [
                self::URI['en'],
                'Provided category for the job does not exist.'
            ],
            'DE: Valid Category UUID that does not exist in DB' => [
                self::URI['de'],
                'Die angegebene Kategorie für den Job existiert nicht.'
            ]
        ];
    }

    /**
     * @dataProvider invalidCategoryUuidDataProvider
     */
    public function testHandleRequestWithInvalidCategoryUuid(
        string $uri,
        string $expectedError
    ): void {
        $this->authenticateClient();

        $jobParameters = $this->getJobParameters();
        $jobParameters['categoryId'] = 'fooBar';

        $this->sendRequest($uri, $jobParameters);

        $this->assertForError(
            $this->response(),
            ['status' => 'error', 'message' => $expectedError],
            'categoryId'
        );
    }

    public function invalidCategoryUuidDataProvider(): array
    {
        return [
            'EN: Valid Category UUID that does not exist in DB' => [
                self::URI['en'],
                'The provided UUID is not valid.'
            ],
            'DE: Valid Category UUID that does not exist in DB' => [
                self::URI['de'],
                'Die angegebene UUID ist ungültig.'
            ]
        ];
    }
}
