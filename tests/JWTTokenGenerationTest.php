<?php

namespace App\Tests;

use App\Kernel;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;

class JWTTokenGenerationTest extends TestCase
{
    private $request;

    protected function setUp() : void
    {
        parent::setUp();

        $this->request = Request::create(
            '/login',
            'POST',
            ['email' => 'auth_user@eresdev.com', 'password' => 'somePassword1145236']
        );
    }

    public function testTokenGeneration() : void
    {
        $kernel = new Kernel('test', true);
        $response = $kernel->handle($this->request);
        $this->assertContains('token', $response->getContent());
    }
}
