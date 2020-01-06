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

    /**
     * @dataProvider validButNonExistingJobUuidDataProvider
     */
    public function testHandleRequestWithValidButNonExistingJobUuid(
        string $uri,
        $expectedError
    ): void {
        $this->authenticateClient();

        $this->sendRequest(
            $uri,
            '28b4640e-f445-4107-bbd4-3768b788e893'
        );
        $response = $this->response();

        $this->assertEquals(
            404,
            $response->getStatusCode()
        );

        $content = $response->getContent();
        $contentObject = json_decode($content);

        $this->assertObjectHasAttribute(
            'uuid',
            $contentObject,
            sprintf(
                "Validation errors does not contain error for invalid %s. " .
                "Errors received are: \n%s",
                'uuid',
                print_r($contentObject, true)
            )
        );

        $this->assertEquals(
            $expectedError,
            $contentObject->uuid,
            sprintf("Validation error received for valid but non existing %s is not as expected.", 'uuid')
        );
    }

    public function validButNonExistingJobUuidDataProvider(): array
    {
        return [
            'EN: ValidButNonExistingJobUuidDataProvider' => [
                self::URI['en'],
                'Requested job was not found. Delete operation failed.'
            ],
            'DE: ValidButNonExistingJobUuidDataProvider' => [
                self::URI['de'],
                'Der angeforderte Job wurde nicht gefunden. Löschvorgang fehlgeschlagen.'
            ]
        ];
    }
}
