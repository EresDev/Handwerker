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

        Assert::assertEquals(401, $response->getStatusCode());

        $content = json_decode($response->getContent());

        switch ($locale) {
            //TODO: add translation for this error message
            case 'en':
                Assert::assertEquals('JWT Token not found', $content->message);
                break;
            case 'de':
                Assert::assertEquals('JWT Token not found', $content->message);
                break;
            default:
                Assert::assertEquals('JWT Token not found', $content->message);
        }
    }
}
