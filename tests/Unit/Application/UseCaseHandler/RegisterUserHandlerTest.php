<?php

namespace App\Tests\Unit\Application\UseCaseHandler;

use App\Application\UseCaseHandler\RegisterUserHandler;
use App\Domain\Exception\ValidationException;
use App\Domain\Repository\RelationalSaverRepository;
use App\Domain\Repository\User\UserSaver;
use App\Service\PasswordEncoder;
use App\Service\Uuid;
use App\Service\Validator;
use App\Application\UseCase\RegisterUser;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class RegisterUserHandlerTest extends KernelTestCase
{
    private PasswordEncoder $passwordEncoder;
    private Validator $validator;
    private UserSaver $userSaver;

    protected function setUp()
    {
        static::bootKernel();
        parent::setUp();

        $this->passwordEncoder = $this->getService(PasswordEncoder::class);
        $this->validator = $this->getService(Validator::class);
        $this->userSaver =
            $this->createMock(UserSaver::class);
    }

    private function getService(string $className)
    {
        return static::$container->get($className);
    }

    public function testHandleWithValidData() : void
    {
        $this->userSaver
            ->expects($this->once())
            ->method('save');

        $command = new RegisterUser(
          Uuid::get(),
          'registerUserHanlderTest@eresdev.com',
            'somePassword@sdf453'
        );

        $handler = new RegisterUserHandler(
            $this->passwordEncoder,
            $this->validator,
            $this->userSaver
        );

        $handler->handle($command);
    }

    public function testHandleWithInValidEmail() : void
    {
        $this->expectException(ValidationException::class);

        $command = new RegisterUser(
            Uuid::get(),
            'invalidEmail',
            'somePassword@sdf453'
        );

        $handler = new RegisterUserHandler(
            $this->passwordEncoder,
            $this->validator,
            $this->userSaver
        );

        $handler->handle($command);
    }
}
