<?php

declare(strict_types=1);

namespace App\Tests\Functional\Infrastructure\Controller;

use App\Domain\Repository\Job\JobFinder;
use App\Tests\Shared\AuthenticatedWebTestCase;
use App\Tests\Shared\Fixture\JobFixture;
use App\Tests\Shared\ObjectMother\JobMother;
use Hautelook\AliceBundle\PhpUnit\ReloadDatabaseTrait;

class UpdateJobControllerTest extends AuthenticatedWebTestCase
{
    use ReloadDatabaseTrait;

    public function testHandleRequestForValidData(): void
    {
        $this->authenticateClient();

        $jobParameters = $this->getJobParameters('title', 'An Updated Title');

        $this->sendRequest($jobParameters);

        $response = $this->response();
        $this->assertEquals(204, $response->getStatusCode());

        /**
         * @var JobFinder $jobFinder
         */
        $jobFinder = $this->getService(JobFinder::class);
        $job = $jobFinder->find($jobParameters['uuid']);
        $this->assertNotNull($job);
        $this->assertEquals($jobParameters['title'], $job->getTitle());
    }

    private function sendRequest(array $parameters): void
    {
        $this->client->request(
            'put',
            '/job',
            $parameters,
            [],
            []
        );
    }

    private function getJobParameters(string $attrToOverride, string $attrValue): array
    {
        $jobData = JobMother::toValidParameterArray();
        $jobData['uuid'] = JobFixture::UUID;
        $jobData[$attrToOverride] = $attrValue;

        return $jobData;
    }
}
