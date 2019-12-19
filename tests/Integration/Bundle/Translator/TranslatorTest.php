<?php

declare(strict_types=1);

namespace App\Tests\Integration\Bundle\Translator;

use App\Tests\Shared\WebTestCase;
use Hautelook\AliceBundle\PhpUnit\RefreshDatabaseTrait;

class TranslatorTest  extends WebTestCase
{
    //TODO: improve test by using dynamically created controller, with independent custom translator files,
    //possibly along with independent custom validations

    use RefreshDatabaseTrait;

    private const EMAIL = 'registerUserControllerTest@eresdev.com';
    private const PASSWORD = 'somePassword1145236';

    protected function setUp(): void
    {
        parent::setUp();
    }

    public function testRegisterUserControllerWithEmptyPasswordForEnglishErrors(): void
    {
        $this->sendRequest(
            '/user',
            ['email' => self::EMAIL, 'password' => '']
        );

        $this->assertForInvalidRequestData('password', 'Password can\'t be blank.');
    }

    private function sendRequest(string $uri, array $parameters): void
    {
        $this->client->request(
            'post',
            $uri,
            $parameters,
            [],
            []
        );
    }

    private function assertForInvalidRequestData(string $invalidField, string $expectedError): void
    {
        $response = $this->response();
        $this->assertEquals(422, $response->getStatusCode());

        $content = $this->response()->getContent();
        $contentObjects = json_decode($content);

        $this->assertObjectHasAttribute($invalidField, $contentObjects[0]);
        $this->assertEquals(
            $expectedError,
            $contentObjects[0]->password
        );
    }

    public function testRegisterUserControllerWithEmptyPasswordForGermanErrors(): void
    {
        $this->sendRequest(
            '/benutzer',
            ['email' => self::EMAIL, 'password' => '']
        );

        $this->assertForInvalidRequestData('password', 'Das Passwort darf nicht leer sein.');
    }
}
