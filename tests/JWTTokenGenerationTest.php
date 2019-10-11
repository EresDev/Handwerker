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

        $this->request = Request::create(
            '/login_check',
            'POST',
            [],
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode(['email' => 'auth_user2@eresdev.com', 'password' => 'somePassword1145236'])
        );
    }

    public function testTokenGeneration() : void
    {
        $kernel = new Kernel('test', true);
        $response = $kernel->handle($this->request);
        $this->assertArrayHasKey(
            'token',
            json_decode($response->getContent(), true),
            'No token received. The content received: \n'.
            $response->getContent()
        );
    }
}
