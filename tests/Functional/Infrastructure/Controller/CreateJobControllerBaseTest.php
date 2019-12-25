<?php

declare(strict_types=1);

namespace App\Tests\Functional\Infrastructure\Controller;

use App\Tests\Shared\ObjectMother\JobMother;

class CreateJobControllerBaseTest extends UpsertJobBaseTestCase
{
    /**
     * @dataProvider uriProvider
     */
    public function testHandleRequestForValidData(string $uri): void
    {
        $this->authenticateClient();

        $this->sendRequest(
            $uri,
            $this->getJobParameters()
        );
        $response = $this->response();
        $this->assertEquals(201, $response->getStatusCode());

        $responseObj = json_decode($response->getContent());
        $this->assertObjectHasAttribute('uuid', $responseObj);
        $this->assertNotNull($responseObj->uuid);
    }

    protected function getJobParameters(): array
    {
        return JobMother::toValidParameterArray();
    }

    protected function getRequestMethod(): string
    {
        return 'post';
    }
}
