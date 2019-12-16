<?php

namespace App\Application\Command;

class CreateJobCommand extends Command
{
    private string $uuid;
    private string $title;
    private string $zipCode;
    private string $city;
    private string $description;
    private \DateTime $executionDateTime;
    private string $categoryId;
    private string $userId;

    public function __construct(
        string $uuid,
        string $title,
        string $zipCode,
        string $city,
        string $description,
        \DateTime $executionDateTime,
        string $categoryId,
        string $userId
    ) {
        $this->uuid = $uuid;
        $this->title = $title;
        $this->zipCode = $zipCode;
        $this->city = $city;
        $this->description = $description;
        $this->executionDateTime = $executionDateTime;
        $this->categoryId = $categoryId;
        $this->userId = $userId;
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

    public function getCategoryId(): string
    {
        return $this->categoryId;
    }

    public function getUserId(): string
    {
        return $this->userId;
    }

    public function getContent(): array
    {
        return [
            'uuid' => $this->uuid,
            'title' => $this->title,
            'zipCode' => $this->zipCode,
            'city' => $this->city,
            'description' => $this->description,
            'executionDateTime' => $this->executionDateTime,
            'categoryId' => $this->categoryId,
            'userId' => $this->userId
        ];
    }
}
