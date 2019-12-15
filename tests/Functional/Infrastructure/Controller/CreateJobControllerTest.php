<?php

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
}