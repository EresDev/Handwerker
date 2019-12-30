<?php

declare(strict_types=1);

namespace App\Tests\Shared;

use App\Tests\Shared\Fixture\UserFixture;
use Hautelook\AliceBundle\PhpUnit\ReloadDatabaseTrait;

class AuthenticatedWebTestCase extends WebTestCase
{
    use ReloadDatabaseTrait;

    protected function authenticateClient(): void
    {
        $this->request(
            'POST',
            '/login_check',
            [],
            [],
            array('CONTENT_TYPE' => 'application/json'),
            json_encode(['email' => UserFixture::EMAIL, 'password' => UserFixture::PLAIN_PASSWORD])
        );

        $data = json_decode($this->response()->getContent(), true);

        $client = static::createClient();
        $client->setServerParameter('HTTP_Authorization', $data['token']);

        $this->client = $client;
    }
}
