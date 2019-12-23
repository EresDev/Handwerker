<?php

declare(strict_types=1);

namespace App\Tests\Functional\Infrastructure\Controller;

use App\Domain\Entity\User;
use App\Tests\Functional\ValidationErrorsAssertionTrait;
use App\Tests\Shared\WebTestCase;
use Hautelook\AliceBundle\PhpUnit\RefreshDatabaseTrait;

class RegisterUserControllerTest extends WebTestCase
{
    use ValidationErrorsAssertionTrait;
    use RefreshDatabaseTrait;
    private const EMAIL = 'registerUserControllerTest@eresdev.com';
    private const PASSWORD = 'somePassword1145236';
    private const URI = ['en' => 'user', 'de' => 'benutzer'];

    /**
     * @dataProvider uriProvider
     */
    public function testHandleRequestWithValidData(string $uri): void
    {
        $this->sendRequest(
            $uri,
            ['email' => self::EMAIL, 'password' => self::PASSWORD]
        );
        $response = $this->response();
        $this->assertEquals(201, $response->getStatusCode());

        $responseObj = json_decode($response->getContent());
        $this->assertObjectHasAttribute('uuid', $responseObj);
        $this->assertNotNull($responseObj->uuid);
    }

    public function uriProvider(): array
    {
        return [
            [self::URI['en']],
            [self::URI['de']]
        ];
    }

    private function sendRequest(string $uri, array $parameters): void
    {
        $this->client->request(
            'post',
            '/' . $uri,
            $parameters,
            [],
            []
        );
    }

    /**
     * @@dataProvider emptyPasswordDataProvider
     */
    public function testHandleRequestWithEmptyPassword(string $uri, string $expectedError): void
    {
        $this->sendRequest(
            $uri,
            ['email' => self::EMAIL, 'password' => '']
        );

        $this->assertForValidationError('password', $expectedError);
    }

    public function emptyPasswordDataProvider(): array
    {
        return [
            [self::URI['en'], 'Password cannot be blank.'],
            [self::URI['de'], 'Das Passwort darf nicht leer sein.']
        ];
    }

    /**
     * @dataProvider invalidEmailDataProvider
     */
    public function testHandleRequestWithInvalidEmail(string $uri, string $expectedError): void
    {
        $this->sendRequest(
            $uri,
            ['email' => 'someInvalidEmail', 'password' => self::PASSWORD]
        );

        $this->assertForValidationError('email', $expectedError);
    }

    public function invalidEmailDataProvider(): array
    {
        return [
            [self::URI['en'], 'Email is not valid.'],
            [self::URI['de'], 'E-Mail ist ungültig.']
        ];
    }

    /**
     * @dataProvider existingEmailDataProvider
     */
    public function testHandleRequestWithExistingEmail(string $uri, string $expectedError): void
    {
        /**
         * @var User $user
         */
        $user = self::$fixtures['user_1'];

        $this->sendRequest(
            $uri,
            ['email' => $user->getEmail(), 'password' => self::PASSWORD]
        );

        $this->assertForValidationError('email', $expectedError);
    }

    public function existingEmailDataProvider(): array
    {
        return [
            [self::URI['en'], 'The email provided is already registered.'],
            [self::URI['de'], 'Die angegebene E-Mail ist bereits registriert.']
        ];
    }
}
