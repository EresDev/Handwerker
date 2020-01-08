<?php

declare(strict_types=1);

namespace App\Tests\Shared;

use App\Tests\Shared\Fixture\UserFixture;
use Hautelook\AliceBundle\PhpUnit\ReloadDatabaseTrait;
use PHPUnit\Framework\Assert;

trait AuthenticatedClientTrait
{
    use WebTestCaseTrait;

    protected function authenticateClient(): void
    {
        $this->request(
            'POST',
            '/login_check',
            ['email' => UserFixture::EMAIL, 'password' => UserFixture::PLAIN_PASSWORD]
        );

        $data = json_decode($this->response()->getContent(), true);

        $client = static::createClient();
        $client->setServerParameter('HTTP_Authorization', $data['token']);

        $this->client = $client;
    }

    public function assertForUnauthenticatedUser(string $locale): void
    {
        $response = $this->response();

        Assert::assertEquals(
            401,
            $response->getStatusCode(),
            'Test to get error message for unauthorized access for the operation failed. ' .
            'Received wrong HTTP status code.'
        );

        $content = json_decode($response->getContent());

        switch ($locale) {
            //TODO: add translation for this error message
            case 'en':
                $error = 'JWT Token not found';
                break;
            case 'de':
                $error = 'JWT Token not found';
                break;
            default:
                $error = 'JWT Token not found';
        }

        Assert::assertEquals(
            $error,
            $content->message,
            'Test to get error message for unauthorized access for this operation failed. ' .
            'We did not get back the error message in the content we were expecting.'
        );
    }
}
