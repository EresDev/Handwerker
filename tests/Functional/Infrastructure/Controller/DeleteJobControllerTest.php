<?php

declare(strict_types=1);

namespace App\Tests\Functional\Infrastructure\Controller;

use App\Tests\Shared\AuthenticatedWebTestCase;
use App\Tests\Shared\Fixture\JobFixture;
use Hautelook\AliceBundle\PhpUnit\RefreshDatabaseTrait;

class DeleteJobControllerTest extends AuthenticatedWebTestCase
{
    use RefreshDatabaseTrait;
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
}
