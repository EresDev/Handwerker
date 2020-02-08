<?php

declare(strict_types=1);

namespace App\Tests\Functional\Infrastructure\Controller;

use App\Domain\Repository\Job\JobFinder;
use App\Domain\ValueObject\Uuid;
use App\Tests\Shared\Fixture\JobFixture;
use App\Tests\Shared\ObjectMother\JobMother;
use Hautelook\AliceBundle\PhpUnit\ReloadDatabaseTrait;

class UpdateJobControllerTest extends UpsertJobBaseTestCase
{
    use ReloadDatabaseTrait;

    /**
     * @dataProvider uriProvider
     */
    public function testHandleRequestForValidData(string $uri): void
    {
        $this->authenticateClient();

        $jobParameters = $this->getJobParameters();
        $jobParameters['title'] = 'An Updated Title';

        $this->sendRequest($uri, $jobParameters);

        $response = $this->response();
        $this->assertEquals(204, $response->getStatusCode());

        /**
         * @var JobFinder $jobFinder
         */
        $jobFinder = $this->getService(JobFinder::class);
        $job = $jobFinder->find(Uuid::createFrom($jobParameters['uuid']));
        $this->assertNotNull($job);
        $this->assertEquals($jobParameters['title'], $job->getTitle());
    }

    protected function getJobParameters(): array
    {
        $jobData = JobMother::toValidParameterArray();
        $jobData['uuid'] = JobFixture::UUID;

        return $jobData;
    }

    protected function getRequestMethod(): string
    {
        return 'put';
    }
}
