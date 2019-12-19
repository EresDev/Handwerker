<?php

declare(strict_types=1);

namespace App\Tests\Functional\Infrastructure\Controller;

use App\Tests\Shared\ObjectMother\JobMother;
use App\Tests\Shared\WebTestCase;
use Hautelook\AliceBundle\PhpUnit\ReloadDatabaseTrait;

class CreateJobControllerTest extends WebTestCase
{
    use ReloadDatabaseTrait;

    protected function setUp(): void
    {
        parent::setUp();
    }

    public function testHandleRequestForValidData(): void
    {
        $this->sendRequest(
            JobMother::toValidParameterArray()
        );
        $response = $this->response();
        $this->assertEquals(201, $response->getStatusCode());

        $responseObj = json_decode($response->getContent());
        $this->assertObjectHasAttribute('uuid', $responseObj);
        $this->assertNotNull($responseObj->uuid);
    }

    private function sendRequest(array $parameters): void
    {
        $this->client->request(
            'post',
            '/job',
            $parameters,
            [],
            []
        );
    }

    public function testHandleRequestForInvalidExecutionDateTimeAsEmptyString(): void
    {
        $jobParameters = JobMother::toValidParameterArray();
        $jobParameters['executionDateTime'] = '';

        $this->sendRequest($jobParameters);

        $this->assertForInvalidRequestData('executionDateTime');
    }

    private function assertForInvalidRequestData(string $invalidField): void
    {
        $response = $this->response();
        $this->assertEquals(422, $response->getStatusCode());

        $content = $this->response()->getContent();
        $contentObjects = json_decode($content);

        $this->assertObjectHasAttribute($invalidField, $contentObjects[0]);
    }

    public function testHandleRequestForInvalidExecutionDateTimeAsNegativeInteger(): void
    {
        $jobParameters = JobMother::toValidParameterArray();
        $timestampNow = (new \DateTime())
            ->modify('+2 days')
            ->getTimestamp();
        $jobParameters['executionDateTime'] = -$timestampNow;

        $this->sendRequest($jobParameters);

        $this->assertForInvalidRequestData('executionDateTime');
    }

}
