<?php

namespace App\Tests\Functional\Infrastructure\Controller;

use App\Tests\WebTestCase;
use Hautelook\AliceBundle\PhpUnit\ReloadDatabaseTrait;

class RegisterUserControllerTest extends WebTestCase
{
    use ReloadDatabaseTrait;

    private const EMAIL = 'registerUserControllerTest@eresdev.com';
    private const PASSWORD = 'somePassword1145236';

    protected function setUp() : void
    {
        parent::setUp();
    }

    public function testHandleRequestWithValidData() : void
    {
        $this->sendRequest(
            ['email' => self::EMAIL, 'password' => self::PASSWORD]
        );
        $response = $this->response();
        $this->assertEquals(200, $response->getStatusCode());

        $responseObj = json_decode($response->getContent());
        $this->assertObjectHasAttribute('uuid', $responseObj);
        $this->assertNotNull($responseObj->uuid);
    }


    public function testHandleRequestWithEmptyPassword() : void
    {
        $this->sendRequest(
            ['email' => self::EMAIL, 'password' => '']
        );
        $response = $this->response();
        $this->assertEquals(422, $response->getStatusCode());

        $content = $this->response()->getContent();
        $contentObjects = json_decode($content);

        $this->assertObjectHasAttribute('password', $contentObjects[0]);
    }

    public function testHandleRequestWithInvalidEmail() : void
    {
        $this->sendRequest(
            ['email' => 'someInvalidEmail', 'password' => self::PASSWORD]
        );
        $response = $this->response();
        $this->assertEquals(422, $response->getStatusCode());

        $content = $this->response()->getContent();
        $contentObjects = json_decode($content);

        $this->assertObjectHasAttribute('email', $contentObjects[0]);
    }

}
