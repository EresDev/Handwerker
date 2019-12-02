<?php

namespace App\Tests\Controller;

use App\Kernel;
use Hautelook\AliceBundle\PhpUnit\RefreshDatabaseTrait;
use Hautelook\AliceBundle\PhpUnit\ReloadDatabaseTrait;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\HttpFoundation\Request;

class CreateUserControllerTest extends KernelTestCase
{
    use ReloadDatabaseTrait;

    private const EMAIL = 'createUserControllerTest@eresdev.com';
    private const PASSWORD = 'somePassword1145236';

    private $request;

    protected function setUp() : void
    {
        parent::setUp();
        self::bootKernel();
    }

    public function testUserCreationWithValidData() : void
    {
        $this->request = Request::create(
            '/user',
            'POST',
            ['email' => self::EMAIL, 'password' => self::PASSWORD],
            [],
            [],
            ['CONTENT_TYPE' => 'application/json']
        );

        $kernel = self::$kernel;
        $response = $kernel->handle($this->request);

        $this->assertEquals(200, $response->getStatusCode());

        $responseArray = json_decode($response->getContent(), true);
        $this->assertEquals(self::EMAIL, $responseArray['email']);
    }
}
