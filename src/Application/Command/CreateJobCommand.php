<?php

declare(strict_types=1);

namespace App\Application\Command;

use DateTime;

class CreateJobCommand extends JobCommand
{
    private string $userId;

    public function __construct(
        string $uuid,
        string $title,
        string $zipCode,
        string $city,
        string $description,
        DateTime $executionDateTime,
        string $categoryId,
        string $userId
    ) {
        parent::__construct($uuid, $title, $zipCode, $city, $description, $executionDateTime, $categoryId);

        $this->userId = $userId;
    }

    public function getUserId(): string
    {
        return $this->userId;
    }

    public function setUserId(string $userId): void
    {
        $this->userId = $userId;
    }

    public function getContent(): array
    {
        $content = parent::getContent();
        $content['userId'] = $this->userId;

        return $content;
    }
}
