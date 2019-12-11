<?php

namespace App\Tests\Functional\Infrastructure\Controller;

use App\Infrastructure\Security\Symfony\PasswordEncoderAdapter;
use App\Tests\Shared\WebTestCase;
use Hautelook\AliceBundle\PhpUnit\ReloadDatabaseTrait;
use Nelmio\Alice\Loader\NativeLoader;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntityValidator;

class RegisterUserControllerTest extends WebTestCase
{
    use ReloadDatabaseTrait;
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
        $this->sendRequest(
            ['email' => 'auth_user2@eresdev.com', 'password' => self::PASSWORD]
        );

        $this->assertForInvalidRequestData('email');
    }

    private function loadFixture(): void
    {
        $loader = new NativeLoader();
        $loader->getFakerGenerator()->addProvider(
            self::$container->get(PasswordEncoderAdapter::class)
        );
        $this->fixture = $loader->loadFile(self::$kernel->getProjectDir().'/fixtures/user.yaml');
    }
}
