<?php

namespace App\Tests\Unit\Application\CommandHandler;

use App\Application\Command\CreateJobCommand;
use App\Application\CommandHandler\CreateJobHandler;
use App\Application\Service\Uuid;
use App\Application\Service\Validator;
use App\Domain\Repository\Job\JobSaver;
use App\Tests\Shared\KernelTestCase;
use App\Tests\Shared\ObjectMother\JobMother;

class CreateJobHandlerTest extends KernelTestCase
{
    private Validator $validator;
    private JobSaver $jobSaver;
    private Uuid $uuidGenerator;

    protected function setUp()
    {
        static::bootKernel();
        parent::setUp();

        $this->validator = $this->getService(Validator::class);
        $this->jobSaver =
            $this->createMock(JobSaver::class);
        $this->uuidGenerator = $this->getService(Uuid::class);
    }

    public function testHandleWithValidData(): void
    {
        $this->jobSaver
            ->expects($this->once())
            ->method('save');

        $validData = JobMother::toValidParameterArray();
        $command = new CreateJobCommand(
            $this->uuidGenerator->generate(),
            $validData['title'],
            $validData['zipCode'],
            $validData['city'],
            $validData['description'],
            $validData['executionDateTime'],
            $validData['categoryId'],
            '3e279073-ca26-41d8-94e8-002e9dc36f9b'
        );

        $handler = new CreateJobHandler(
            $this->validator,
            $this->jobSaver
        );

        $handler->handle($command);
    }
}
