<?php

declare(strict_types=1);

namespace App\Application\Command;

use App\Domain\ValueObject\Uuid;
use DateTime;

abstract class JobCommand
{
    protected Uuid $uuid;
    protected string $title;
    protected string $zipCode;
    protected string $city;
    protected string $description;
    protected DateTime $executionDateTime;
    protected Uuid $categoryId;

    public function __construct(
        Uuid $uuid,
        string $title,
        string $zipCode,
        string $city,
        string $description,
        DateTime $executionDateTime,
        Uuid $categoryId
    ) {
        $this->uuid = $uuid;
        $this->title = $title;
        $this->zipCode = $zipCode;
        $this->city = $city;
        $this->description = $description;
        $this->executionDateTime = $executionDateTime;
        $this->categoryId = $categoryId;
    }

    public function getUuid(): Uuid
    {
        return $this->uuid;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getZipCode(): string
    {
        return $this->zipCode;
    }

    public function getCity(): string
    {
        return $this->city;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getExecutionDateTime(): DateTime
    {
        return $this->executionDateTime;
    }

    public function getCategoryId(): Uuid
    {
        return $this->categoryId;
    }

    public function __toString(): string
    {
        return print_r(
            [
                'uuid' => $this->uuid->getValue(),
                'title' => $this->title,
                'zipCode' => $this->zipCode,
                'city' => $this->city,
                'description' => $this->description,
                'executionDateTime' => $this->executionDateTime,
                'categoryId' => $this->categoryId
            ],
            true
        );
    }
}
