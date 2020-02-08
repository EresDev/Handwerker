<?php

declare(strict_types=1);

namespace App\Tests\Unit\Application\CommandHandler;

use App\Application\Command\DeleteJobCommand;
use App\Application\CommandHandler\DeleteJobHandler;
use App\Domain\Repository\Job\JobByUserFinder;
use App\Domain\Repository\Job\JobDeleter;
use App\Domain\ValueObject\Uuid;
use App\Tests\Shared\Fixture\JobFixture;
use App\Tests\Shared\Fixture\UserFixture;
use App\Tests\Shared\KernelTestCase;
use PHPUnit\Framework\MockObject\MockObject;

class DeleteJobHandlerTest extends KernelTestCase
{
    private MockObject $jobByUserFinder;
    private MockObject $jobDeleter;

    protected function setUp(): void
    {
        static::bootKernel();

        $this->jobDeleter =
            $this->createMock(JobDeleter::class);

        $this->jobByUserFinder = $this->createMock(JobByUserFinder::class);
        $this->jobByUserFinder
            ->method('findOneByUser')
            ->willReturn(JobFixture::getInstance());
    }

    public function testHandleRequestWithValidAndExistingJobUuid(): void
    {
        $this->jobDeleter
            ->expects($this->atLeast(1))
            ->method('delete');

        $command = new DeleteJobCommand(
            Uuid::createFrom(JobFixture::UUID),
            UserFixture::getInstance()
        );

        $handler = new DeleteJobHandler(
            $this->jobByUserFinder,
            $this->jobDeleter
        );

        $handler->handle($command);
    }
}
