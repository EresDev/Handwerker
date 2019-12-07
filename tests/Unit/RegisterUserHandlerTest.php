<?php

namespace App\Tests\Unit;

use App\Domain\Exception\ValidationException;
use App\Domain\Repository\RelationalSaverRepository;
use App\Domain\Service\PasswordEncoder;
use App\Domain\Service\Validator;
use App\Usecase\Command\RegisterUserCommand;
use App\Usecase\RegisterUserHandler;
use Ramsey\Uuid\Uuid;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class RegisterUserHandlerTest extends KernelTestCase
{
    private $passwordEncoder;
    private $validator;
    private $relationalSaverRepository;

    protected function setUp()
    {

        static::bootKernel();
        parent::setUp();

        $this->passwordEncoder = $this->getService(PasswordEncoder::class);
        $this->validator = $this->getService(Validator::class);
        $this->relationalSaverRepository =
            $this->createMock(RelationalSaverRepository::class);
    }

    private function getService(string $className)
    {
        return static::$container->get($className);
    }

    public function testHandleWithValidData() : void
    {
        $this->relationalSaverRepository
            ->expects($this->once())
            ->method('save');

        $command = new RegisterUserCommand(
          Uuid::uuid1(),
          'registerUserHanlderTest@eresdev.com',
            'somePassword@sdf453'
        );

        $handler = new RegisterUserHandler(
            $this->passwordEncoder,
            $this->validator,
            $this->relationalSaverRepository
        );

        $handler->handle($command);
    }

    public function testHandleWithInValidEmail() : void
    {
        $this->expectException(ValidationException::class);

        $command = new RegisterUserCommand(
            Uuid::uuid1(),
            'invalidEmail',
            'somePassword@sdf453'
        );

        $handler = new RegisterUserHandler(
            $this->passwordEncoder,
            $this->validator,
            $this->relationalSaverRepository
        );

        $handler->handle($command);
    }
}
