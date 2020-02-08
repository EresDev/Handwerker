<?php

declare(strict_types=1);

namespace App\Application\Command;

use App\Domain\Entity\User;
use App\Domain\ValueObject\Uuid;
use DateTime;

class CreateJobCommand extends JobCommand
{
    private User $user;

    public function __construct(
        Uuid $uuid,
        string $title,
        string $zipCode,
        string $city,
        string $description,
        DateTime $executionDateTime,
        Uuid $categoryId,
        User $user
    ) {
        parent::__construct($uuid, $title, $zipCode, $city, $description, $executionDateTime, $categoryId);

        $this->user = $user;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function getContent(): array
    {
        $content = parent::getContent();
        $content['userId'] = $this->user->getUuid();

        return $content;
    }
}
