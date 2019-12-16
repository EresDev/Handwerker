<?php

namespace App\Tests\Unit\Application\CommandHandler;

use App\Application\Command\CreateJobCommand;
use App\Application\CommandHandler\CreateJobHandler;
use App\Application\Service\Association\AssociatedEntityCreator;
use App\Application\Service\Uuid;
use App\Application\Service\Validator;
use App\Domain\Exception\ValidationException;
use App\Domain\Repository\Job\JobSaver;
use App\Tests\Shared\KernelTestCase;
use App\Tests\Shared\ObjectMother\JobMother;

class CreateJobHandlerTest extends KernelTestCase
{
    private Validator $validator;
    private JobSaver $jobSaver;
    private Uuid $uuidGenerator;
    private AssociatedEntityCreator $associatedEntityCreator;

    protected function setUp()
    {
        static::bootKernel();
        parent::setUp();

        $this->validator = $this->getService(Validator::class);
        $this->jobSaver =
            $this->createMock(JobSaver::class);
        $this->uuidGenerator = $this->getService(Uuid::class);
        $this->associatedEntityCreator = $this->getService(AssociatedEntityCreator::class);
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
            $this->associatedEntityCreator
        );

        $handler->handle($command);
    }

    private function getCommandFrom(array $commandAttrs): CreateJobCommand
    {
        return new CreateJobCommand(
            $this->uuidGenerator->generate(),
            $commandAttrs['title'],
            $commandAttrs['zipCode'],
            $commandAttrs['city'],
            $commandAttrs['description'],
            $commandAttrs['executionDateTime'],
            $commandAttrs['categoryId'],
            '3e279073-ca26-41d8-94e8-002e9dc36f9b'
        );
    }

    public function testHandleWithExecutionDatetimeBeforeAcceptableTime(): void
    {
        $this->expectException(ValidationException::class);
        $testData = JobMother::toValidParameterArray(false);
        $testData['executionDateTime'] = (new \DateTime())->modify('+23 hours');

        $command = $this->getCommandFrom($testData);

        $handler = new CreateJobHandler(
            $this->validator,
            $this->jobSaver,
            $this->associatedEntityCreator
        );
        try {
            $handler->handle($command);
        } catch (ValidationException $exception) {
            $errors = $exception->getMessagesForEndUser();
            $this->assertArrayHasKey('executionDateTime', $errors[0]);
            $this->assertCount(1, $errors);
            throw $exception;
        }
    }
}
