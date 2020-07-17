<?php

declare(strict_types=1);

namespace App\Tests\Integration\Bundle\LexikJWTAuthenticationBundle;

use App\Infrastructure\Security\Symfony\PasswordEncoder;
use App\Kernel;
use App\Tests\Shared\Fixture\UserFixture;
use Hautelook\AliceBundle\PhpUnit\RefreshDatabaseTrait;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;

class JWTTokenGenerationTest extends KernelTestCase
{
    private $request;

    use RefreshDatabaseTrait;

    protected function setUp() : void
    {
        parent::setUp();
        self::bootKernel();
    }

    public function testTokenGenerationForExistingUser() : void
    {
        $this->request = Request::create(
            '/login_check',
            'POST',
            ['email' => UserFixture::EMAIL, 'password' => UserFixture::PLAIN_PASSWORD]
        );

        $kernel = self::$kernel;
        $response = $kernel->handle($this->request);

        $this->assertEquals(
            204,
            $response->getStatusCode(),
            'JWT login check, to receive token failed. Got invalid status code.'
        );

        $this->assertEquals(
            'Authorization',
            $response->headers->getCookies(ResponseHeaderBag::COOKIES_FLAT)[0]->getName(),
            "No token received in the cookie. \n"
        );

        $this->assertNotNull(
            $response->headers->getCookies(ResponseHeaderBag::COOKIES_FLAT)[0]->getValue(),
            "No token received in the cookie."
        );
    }

    public function testTokenGenerationErrorNonExistingUser() : void
    {
        $this->request = Request::create(
            '/login_check',
            'POST',
            ['email' => 'userShouldNotExistInDB@eresdev.com', 'password' => 'somePassword1145236']
        );

        $kernel = new Kernel('test', true);
        $response = $kernel->handle($this->request);

        $this->assertEquals(401, $response->getStatusCode());
    }
}
