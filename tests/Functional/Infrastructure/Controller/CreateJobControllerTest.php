<?php

declare(strict_types=1);

namespace App\Tests\Functional\Infrastructure\Controller;

use App\Tests\Functional\ValidationErrorsAssertionTrait;
use App\Tests\Shared\AuthenticatedWebTestCase;
use App\Tests\Shared\ObjectMother\JobMother;

class CreateJobControllerTest extends AuthenticatedWebTestCase
{
    use ValidationErrorsAssertionTrait;
    private const URI = ['en' => 'job', 'de' => 'arbeit'];

    /**
     * @dataProvider uriProvider
     */
    public function testHandleRequestForValidData(string $uri): void
    {
        $this->authenticateClient();

        $this->sendRequest(
            $uri,
            JobMother::toValidParameterArray()
        );
        $response = $this->response();
        $this->assertEquals(201, $response->getStatusCode());

        $responseObj = json_decode($response->getContent());
        $this->assertObjectHasAttribute('uuid', $responseObj);
        $this->assertNotNull($responseObj->uuid);
    }

    public function uriProvider(): array
    {
        return [
            'EN URI' => [self::URI['en']],
            'DE URI' => [self::URI['de']]
        ];
    }

    /**
     * @dataProvider unauthenticatedDataProvider
     */
    public function testHandleRequestForValidDataUnauthenticated(string $uri, string $expectedError): void
    {
        $this->sendRequest(
            $uri,
            JobMother::toValidParameterArray()
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

    private function sendRequest(string $uri, array $parameters): void
    {
        $this->client->request(
            'post',
            '/' . $uri,
            $parameters,
            [],
            []
        );
    }

    /**
     * @dataProvider invalidExecutionDateTimeDataProvider
     */
    public function testHandleRequestForInvalidExecutionDateTimeAsEmptyString(
        string $uri,
        string $expectedError
    ): void {
        $this->authenticateClient();

        $jobParameters = JobMother::toValidParameterArray();
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
        $jobParameters = JobMother::toValidParameterArray();
        $timestampNow = (new \DateTime())
            ->modify('+2 days')
            ->getTimestamp();
        $jobParameters['executionDateTime'] = -$timestampNow;

        $this->sendRequest($uri, $jobParameters);

        $this->assertForValidationError('executionDateTime', $expectedError);
    }
}
