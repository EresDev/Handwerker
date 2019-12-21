<?php

declare(strict_types=1);

namespace App\Tests\Unit\Application\CommandHandler;

use App\Application\Command\UpdateJobCommand;
use App\Application\CommandHandler\UpdateJobHandler;
use App\Application\Service\JobUpdaterService;
use App\Application\Service\Uuid;
use App\Application\Service\Validator;
use App\Domain\Repository\Job\JobUpdater;
use App\Tests\Shared\Fixture\JobFixture;
use App\Tests\Shared\KernelTestCase;
use App\Tests\Shared\ObjectMother\JobMother;

class UpdateJobHandlerTest extends KernelTestCase
{
    private Validator $validator;
    private JobUpdater $jobUpdater;
    private Uuid $uuidGenerator;
    private JobUpdaterService $jobUpdaterService;

    protected function setUp(): void
    {
        static::bootKernel();

        $this->validator = $this->getService(Validator::class);
        $this->jobUpdater =
            $this->createMock(JobUpdater::class);
        $this->uuidGenerator = $this->getService(Uuid::class);
        $this->jobUpdaterService = $this->getService(JobUpdaterService::class);
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

    private function getCommandFrom(array $commandAttrs): UpdateJobCommand
    {
        return new UpdateJobCommand(
            JobFixture::UUID,
            $commandAttrs['title'],
            $commandAttrs['zipCode'],
            $commandAttrs['city'],
            $commandAttrs['description'],
            $commandAttrs['executionDateTime'],
            $commandAttrs['categoryId']
        );
    }
}
