<?php

declare(strict_types=1);

namespace App\Tests\Functional\Infrastructure\Controller;

use App\Tests\Functional\ValidationErrorsAssertionTrait;
use App\Tests\Shared\AuthenticatedWebTestCase;

abstract class UpsertJobBaseTestCase extends AuthenticatedWebTestCase
{
    use ValidationErrorsAssertionTrait;
    private const URI = ['en' => 'job', 'de' => 'arbeit'];

    protected function sendRequest(string $uri, array $parameters): void
    {
        $this->client->request(
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
     * @dataProvider unauthenticatedDataProvider
     */
    public function testHandleRequestForValidDataUnauthenticated(string $uri, string $expectedError): void
    {
        $this->sendRequest(
            $uri,
            $this->getJobParameters()
        );
        $response = $this->response();
        $this->assertEquals(
            401,
            $response->getStatusCode(),
            'Test to get error message for unauthorized access to create a new job failed. ' .
            'Received wrong HTTP status code.'
        );

        $responseObj = json_decode($response->getContent());
        $this->assertEquals(
            $expectedError,
            $responseObj->message,
            'Test to get error message for unauthorized access to create a new job failed. ' .
            'We did not get back the error message we ' .
            'were expecting.'
        );
    }

    public function unauthenticatedDataProvider(): array
    {
        //TODO: add translation for this error message
        return [
            'EN: Unauthenticated Error' => [self::URI['en'], 'JWT Token not found'],
            'DE: Unauthenticated Error' => [self::URI['de'], 'JWT Token not found']
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

        $this->assertForValidationError('executionDateTime', $expectedError);
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
        $timestampNow = (new \DateTime())
            ->modify('+2 days')
            ->getTimestamp();
        $jobParameters['executionDateTime'] = -$timestampNow;

        $this->sendRequest($uri, $jobParameters);

        $this->assertForValidationError('executionDateTime', $expectedError);
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

        $this->assertForValidationError('categoryId', $expectedError);
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
}
