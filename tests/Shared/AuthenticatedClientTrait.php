<?php

declare(strict_types=1);

namespace App\Tests\Shared;

use App\Tests\Shared\Fixture\UserFixture;
use PHPUnit\Framework\Assert;
use Symfony\Component\BrowserKit\Cookie;

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

        $jwt = $this->client->getCookieJar()->get('Authorization')->getValue();

        $client = static::createClient();
        $client->getCookieJar()->set(
            new Cookie('Authorization', $jwt)
        );

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
