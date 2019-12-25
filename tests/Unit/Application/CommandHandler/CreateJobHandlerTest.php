<?php

declare(strict_types=1);

namespace App\Tests\Unit\Application\CommandHandler;

use App\Application\Command\CreateJobCommand;
use App\Application\CommandHandler\CreateJobHandler;
use App\Application\Service\Factory\JobFactoryImpl;
use App\Application\Service\Uuid;
use App\Application\Service\Validator;
use App\Domain\Entity\User;
use App\Domain\Repository\Job\JobSaver;
use App\Tests\Shared\ObjectMother\JobMother;

class CreateJobHandlerTest extends UpsertJobHandlerBaseTestCase
{
    private Validator $validator;
    private JobSaver $jobSaver;
    private Uuid $uuidGenerator;
    private JobFactoryImpl $jobFactory;

    protected function setUp(): void
    {
        static::bootKernel();

        $this->validator = $this->getService(Validator::class);
        $this->jobSaver =
            $this->createMock(JobSaver::class);
        $this->uuidGenerator = $this->getService(Uuid::class);
        $this->jobFactory = $this->getService(JobFactoryImpl::class);
    }

    public function testHandleWithValidData(): void
    {
        $this->jobSaver
            ->expects($this->once())
            ->method('save');

        $validData = JobMother::toValidParameterArray(false);

        $command = $this->getCommandFrom($validData);

        $handler = new CreateJobHandler(
            $this->validator,
            $this->jobSaver,
            $this->jobFactory
        );

        $handler->handle($command);
    }

    protected function getCommandFrom(array $commandAttrs): CreateJobCommand
    {
        return new CreateJobCommand(
            $this->uuidGenerator->generate(),
            $commandAttrs['title'],
            $commandAttrs['zipCode'],
            $commandAttrs['city'],
            $commandAttrs['description'],
            $commandAttrs['executionDateTime'],
            $commandAttrs['categoryId'],
            $this->createMock(User::class)
        );
    }

    protected function getHandlerInstance(): CreateJobHandler
    {
        return new CreateJobHandler(
            $this->validator,
            $this->jobSaver,
            $this->jobFactory
        );
    }
}
