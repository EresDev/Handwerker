<?php

declare(strict_types=1);

namespace App\Tests\Functional\Infrastructure\Controller;

use App\Tests\Shared\AuthenticatedClientTrait;
use App\Tests\Shared\Fixture\JobFixture;
use App\Tests\Shared\Functional\Assertion\Assertion404NotFoundTrait;
use App\Tests\Shared\WebTestCase;
use Hautelook\AliceBundle\PhpUnit\RefreshDatabaseTrait;

class DeleteJobControllerTest extends WebTestCase
{
    use RefreshDatabaseTrait;
    use AuthenticatedClientTrait;
    use Assertion404NotFoundTrait;
    private const URI = ['en' => 'job', 'de' => 'arbeit'];

    /**
     * @dataProvider uriProvider
     */
    public function testHandleRequestWithValidAndExistingJobUuid(string $uri): void
    {
        $this->authenticateClient();

        $this->sendRequest(
            $uri,
            JobFixture::UUID
        );
        $response = $this->response();
        $this->assertEquals(
            204,
            $response->getStatusCode(),
            'Delete operation failed for valid and existing Job.'
        );
    }

    public function uriProvider(): array
    {
        return [
            [self::URI['en']],
            [self::URI['de']]
        ];
    }

    private function sendRequest(string $uri, string $uuid): void
    {
        $this->client->request(
            'delete',
            '/' . $uri . '/' . $uuid
        );
    }

    /**
     * @dataProvider validButNonExistingJobUuidDataProvider
     */
    public function testHandleRequestWithValidButNonExistingJobUuid(
        string $uri,
        array $expectedContent
    ): void {
        $this->authenticateClient();

        $this->sendRequest(
            $uri,
            '28b4640e-f445-4107-bbd4-3768b788e893'
        );

        $this->assertForValidButNonExistingEntityUuid(
            $expectedContent,
            $this->response()
        );
    }

    public function validButNonExistingJobUuidDataProvider(): array
    {
        return [
            'EN: ValidButNonExistingJobUuidDataProvider' => [
                self::URI['en'],
                ['Requested job was not found. Delete operation failed.']
            ],
            'DE: ValidButNonExistingJobUuidDataProvider' => [
                self::URI['de'],
                ['Der angeforderte Job wurde nicht gefunden. Löschvorgang fehlgeschlagen.']
            ]
        ];
    }

    /**
     * @dataProvider unauthenticatedUserTestDataProvider
     */
    public function testHandleRequestWithValidJobUuidForUnauthenticatedUser(
        string $uri,
        string $locale
    ): void {
        $this->sendRequest($uri, JobFixture::UUID);
        $this->assertForUnauthenticatedUser($locale);
    }

    public function unauthenticatedUserTestDataProvider(): array
    {
        return [
            'EN: Unauthenticated Error' => [self::URI['en'], 'en'],
            'DE: Unauthenticated Error' => [self::URI['de'], 'de']
        ];
    }
}
