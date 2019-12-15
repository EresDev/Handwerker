<?php

namespace App\Application\Command;

class CreateJobCommand
{
    private string $uuid;
    private string $title;
    private string $zipCode;
    private string $city;
    private string $description;
    private \DateTime $executionDateTime;
    private int $categoryId;
    private string $userId;

    public function __construct(
        string $uuid,
        string $title,
        string $zipCode,
        string $city,
        string $description,
        \DateTime $executionDateTime,
        int $categoryId,
        string $userId
    ) {
        $this->uuid = $uuid;
        $this->title = $title;
        $this->zipCode = $zipCode;
        $this->city = $city;
        $this->description = $description;
        $this->executionDateTime = $executionDateTime;
        $this->categoryId = $categoryId;
        $this->userId = $uuid;
    }

    public function getUuid(): string
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

    public function getExecutionDateTime(): \DateTime
    {
        return $this->executionDateTime;
    }

    public function getCategoryId(): int
    {
        return $this->categoryId;
    }

    public function getUserId(): string
    {
        return $this->userId;
    }
}
