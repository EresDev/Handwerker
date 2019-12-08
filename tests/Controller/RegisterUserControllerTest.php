<?php

namespace App\Tests\Controller;

use Hautelook\AliceBundle\PhpUnit\ReloadDatabaseTrait;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class RegisterUserControllerTest extends WebTestCase
{
    use ReloadDatabaseTrait;

    private const EMAIL = 'registerUserControllerTest@eresdev.com';
    private const PASSWORD = 'somePassword1145236';


    protected $client;
    private $request;

    protected function setUp() : void
    {
        parent::setUp();
        self::bootKernel();
        $this->client = static::createClient();
    }

    public function testHandleRequestWithValidData() : void
    {
        $this->sendRequest(
            ['email' => self::EMAIL, 'password' => self::PASSWORD]
        );
        $response = $this->client->getResponse();
        $this->assertEquals(200, $response->getStatusCode());

        $responseObj = json_decode($response->getContent());
        $this->assertObjectHasAttribute('userUuid', $responseObj);
    }

    private function sendRequest(array $parameters) : void
    {
        $this->client->request(
            'post',
            '/user',
            $parameters,
            [],
            []
        );
    }

    protected function request(
        string $method,
        string $uri,
        array $parameters=[],
        array $files=[],
        array $server=[],
        string $content=null,
        bool $changeHistory=true
    ) : void {
        $this->client->request(
            $method,
            $uri,
            $parameters,
            $files,
            $server,
            $content,
            $changeHistory
        );
    }

}
