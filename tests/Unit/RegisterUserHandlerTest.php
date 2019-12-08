<?php

namespace App\Tests\Unit;

use App\Domain\Exception\ValidationException;
use App\Domain\Repository\RelationalSaverRepository;
use App\Domain\Repository\SaveRepository;
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
    private SaveRepository $saveRepository;

    protected function setUp()
    {
        static::bootKernel();
        parent::setUp();

        $this->passwordEncoder = $this->getService(PasswordEncoder::class);
        $this->validator = $this->getService(Validator::class);
        $this->saveRepository =
            $this->createMock(SaveRepository::class);
    }

    private function getService(string $className)
    {
        return static::$container->get($className);
    }

    public function testHandleWithValidData() : void
    {
        $this->saveRepository
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
            $this->saveRepository
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
            $this->saveRepository
        );

        $handler->handle($command);
    }
}
