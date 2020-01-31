<?php

declare(strict_types=1);

namespace App\Tests\Functional\Infrastructure\Controller;

use App\Tests\Shared\AuthenticatedClientTrait;
use App\Tests\Shared\Fixture\JobFixture;
use App\Tests\Shared\Functional\Assertion\Assertion404NotFoundTrait;
use App\Tests\Shared\WebTestCase;
use Hautelook\AliceBundle\PhpUnit\RefreshDatabaseTrait;

class GetJobControllerTest extends WebTestCase
{
    use RefreshDatabaseTrait;
    use AuthenticatedClientTrait;
    use Assertion404NotFoundTrait;
    private const URI = ['en' => 'job', 'de' => 'arbeit'];

    /**
     * @dataProvider uriProvider
     */
    public function testHandleRequestWithValidJobUuid(string $uri): void
    {
        $this->authenticateClient();

        $this->sendRequest($uri, JobFixture::UUID);
        $response = $this->response();

        $this->assertEquals(200, $response->getStatusCode());

        $job = json_decode($response->getContent());

        $this->assertEquals(JobFixture::UUID, $job->uuid);
        $this->assertEquals(JobFixture::TITLE, $job->title);
        $this->assertEquals(JobFixture::DESCRIPTION, $job->description);
        $this->assertEquals(JobFixture::ZIP_CODE, $job->zipCode);
        $this->assertEquals(JobFixture::CITY, $job->city);
        $this->assertEquals(JobFixture::CATEGORY_ID, $job->category->uuid);
    }

    public function uriProvider(): array
    {
        return [
            [self::URI['en']],
            [self::URI['de']]
        ];
    }

    private function sendRequest(string $uri, string $jobUuid): void
    {
        $this->client->request(
            'get',
            '/' . $uri . '/' . $jobUuid,
            [],
            [],
            []
        );
    }

    /**
     * @dataProvider uriProvider
     */
    public function testHandleRequestWithValidJobUuidThatDoesNotExist(string $uri): void
    {
        $this->authenticateClient();

        $this->sendRequest($uri, 'd38b1a7a-2126-4b74-aac5-fb6129de38ec');

        $this->assertForValidButNonExistingEntityUuid(
            [],
            $this->response()
        );
    }

    /**
     * @dataProvider unauthenticatedTestDataProvider
     */
    public function testHandleRequestWithValidJobUuidForUnauthenticatedUser(
        string $uri,
        string $locale
    ): void {
        $this->sendRequest($uri, JobFixture::UUID);
        $this->assertForUnauthenticatedUser($locale);
    }

    public function unauthenticatedTestDataProvider(): array
    {
        return [
            'EN: Unauthenticated Error' => [self::URI['en'], 'en'],
            'DE: Unauthenticated Error' => [self::URI['de'], 'de']
        ];
    }
}
