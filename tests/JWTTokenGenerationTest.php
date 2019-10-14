<?php

namespace App\Tests;

use App\Kernel;
use App\ThirdParty\Security\Symfony\PasswordEncoder;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;

class JWTTokenGenerationTest extends TestCase
{
    private $request;

    protected function setUp() : void
    {
        parent::setUp();


    }

    public function testTokenGeneration() : void
    {
        $this->request = Request::create(
            '/login_check',
            'POST',
            [],
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode(['email' => 'auth_user2@eresdev.com', 'password' => 'somePassword1145236'])
        );

        $kernel = new Kernel('test', true);
        $response = $kernel->handle($this->request);
        $this->assertArrayHasKey(
            'token',
            json_decode($response->getContent(), true),
            'No token received. The content received: \n'.
            $response->getContent()
        );
    }

    public function testTokenGenerationErrorNonExistingUser() : void
    {

        $this->request = Request::create(
            '/login_check',
            'POST',
            [],
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode(['email' => 'userDoesNotExistInDB@eresdev.com', 'password' => 'somePassword1145236'])
        );

        $kernel = new Kernel('test', true);
        $response = $kernel->handle($this->request);

        $this->assertEquals(401, $response->getStatusCode());

        $responseArray = json_decode($response->getContent(), true);


        $this->assertStringContainsString(
            'No user found',
            $responseArray['message'],
            'Unable to find specified string for error. Content received: \n'.
            $response->getContent()
        );
    }
}
