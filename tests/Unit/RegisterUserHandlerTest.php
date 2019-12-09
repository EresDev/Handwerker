<?php

namespace App\Tests\Unit;

use App\Domain\Exception\ValidationException;
use App\Domain\Repository\RelationalSaverRepository;
use App\Domain\Repository\User\UserSaver;
use App\Domain\Service\PasswordEncoder;
use App\Domain\Service\Uuid;
use App\Domain\Service\Validator;
use App\Usecase\Command\RegisterUserCommand;
use App\Usecase\RegisterUserHandler;
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

        $command = new RegisterUserCommand(
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

        $command = new RegisterUserCommand(
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
