<?php

namespace App\Tests\Functional\Infrastructure\Controller;

use App\Domain\Entity\User;
use App\Tests\Shared\WebTestCase;
use Hautelook\AliceBundle\PhpUnit\RefreshDatabaseTrait;

class RegisterUserControllerTest extends WebTestCase
{
    use RefreshDatabaseTrait;

    private const EMAIL = 'registerUserControllerTest@eresdev.com';
    private const PASSWORD = 'somePassword1145236';

    protected function setUp(): void
    {
        parent::setUp();
    }

    public function testHandleRequestWithValidData(): void
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

    public function testHandleRequestWithEmptyPassword(): void
    {
        $this->sendRequest(
            ['email' => self::EMAIL, 'password' => '']
        );

        $this->assertForInvalidRequestData('password');
    }

    private function assertForInvalidRequestData(string $invalidField): void
    {
        $response = $this->response();
        $this->assertEquals(422, $response->getStatusCode());

        $content = $this->response()->getContent();
        $contentObjects = json_decode($content);

        $this->assertObjectHasAttribute($invalidField, $contentObjects[0]);
    }

    public function testHandleRequestWithInvalidEmail(): void
    {
        $this->sendRequest(
            ['email' => 'someInvalidEmail', 'password' => self::PASSWORD]
        );

        $this->assertForInvalidRequestData('email');
    }

    public function testHandleRequestWithExistingEmail(): void
    {
        /**
         * @var User $user
         */
        $user = self::$fixtures['user_1'];

        $this->sendRequest(
            ['email' => $user->getEmail(), 'password' => self::PASSWORD]
        );

        $this->assertForInvalidRequestData('email');
    }
}
