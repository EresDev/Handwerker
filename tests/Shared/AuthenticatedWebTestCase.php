<?php

declare(strict_types=1);

namespace App\Tests\Shared;

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
            json_encode(['email' => 'auth_user2@eresdev.com', 'password' => 'somePassword1145236'])
        );

        $data = json_decode($this->response()->getContent(), true);

        $client = static::createClient();
        $client->setServerParameter('HTTP_Authorization', sprintf('Bearer %s', $data['token']));

        $this->client = $client;
    }
}
