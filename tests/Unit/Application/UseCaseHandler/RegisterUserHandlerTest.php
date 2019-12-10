<?php

namespace App\Tests\Unit\Application\UseCaseHandler;

use App\Application\Command\RegisterUserCommand;
use App\Application\CommandHandler\RegisterUserHandler;
use App\Application\Service\PasswordEncoder;
use App\Application\Service\Uuid;
use App\Application\Service\Validator;
use App\Domain\Exception\ValidationException;
use App\Domain\Repository\User\UserSaver;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class RegisterUserHandlerTest extends KernelTestCase
{
    private PasswordEncoder $passwordEncoder;
    private Validator $validator;
    private UserSaver $userSaver;
    private Uuid $uuidGenerator;

    protected function setUp()
    {
        static::bootKernel();
        parent::setUp();

        $this->passwordEncoder = $this->getService(PasswordEncoder::class);
        $this->validator = $this->getService(Validator::class);
        $this->userSaver =
            $this->createMock(UserSaver::class);
        $this->uuidGenerator = $this->getService(Uuid::class);
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
            $this->uuidGenerator->generate(),
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

    public function testHandleWithInValidEmail(): void
    {
        $this->expectException(ValidationException::class);

        $command = new RegisterUserCommand(
            $this->uuidGenerator->generate(),
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
