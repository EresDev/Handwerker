<?php

declare(strict_types=1);

namespace App\Tests\Unit\Application\CommandHandler;

use App\Application\Command\UpdateJobCommand;
use App\Application\CommandHandler\UpdateJobHandler;
use App\Application\Service\Modifier\JobModifier;
use App\Application\Service\Validator;
use App\Domain\Repository\Job\JobUpdater;
use App\Domain\ValueObject\Uuid;
use App\Tests\Shared\Fixture\JobFixture;
use App\Tests\Shared\ObjectMother\JobMother;

class UpdateJobHandlerTest extends UpsertJobHandlerBaseTestCase
{
    private Validator $validator;
    private JobUpdater $jobUpdater;
    private JobModifier $jobUpdaterService;

    protected function setUp(): void
    {
        static::bootKernel();

        $this->validator = $this->getService(Validator::class);
        $this->jobUpdater =
            $this->createMock(JobUpdater::class);
        $this->jobUpdaterService = $this->getService(JobModifier::class);
    }

    public function testHandleWithValidData(): void
    {
        $this->jobUpdater
            ->expects($this->once())
            ->method('update');

        $validData = JobMother::toValidParameterArray(false);

        $command = $this->getCommandFrom($validData);

        $handler = new UpdateJobHandler(
            $this->validator,
            $this->jobUpdater,
            $this->jobUpdaterService
        );

        $handler->handle($command);
    }

    protected function getCommandFrom(array $commandAttrs): UpdateJobCommand
    {
        return new UpdateJobCommand(
            Uuid::createFrom(JobFixture::UUID),
            $commandAttrs['title'],
            $commandAttrs['zipCode'],
            $commandAttrs['city'],
            $commandAttrs['description'],
            $commandAttrs['executionDateTime'],
            Uuid::createFrom($commandAttrs['categoryId'])
        );
    }

    protected function getHandlerInstance(): UpdateJobHandler
    {
        return new UpdateJobHandler(
            $this->validator,
            $this->jobUpdater,
            $this->jobUpdaterService
        );
    }
}
