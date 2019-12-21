<?php

declare(strict_types=1);

namespace App\Application\Command;

use DateTime;

abstract class JobCommand extends Command
{
    protected string $uuid;
    protected string $title;
    protected string $zipCode;
    protected string $city;
    protected string $description;
    protected DateTime $executionDateTime;
    protected string $categoryId;

    public function __construct(
        string $uuid,
        string $title,
        string $zipCode,
        string $city,
        string $description,
        DateTime $executionDateTime,
        string $categoryId
    ) {
        $this->uuid = $uuid;
        $this->title = $title;
        $this->zipCode = $zipCode;
        $this->city = $city;
        $this->description = $description;
        $this->executionDateTime = $executionDateTime;
        $this->categoryId = $categoryId;
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

    public function getExecutionDateTime(): DateTime
    {
        return $this->executionDateTime;
    }

    public function getCategoryId(): string
    {
        return $this->categoryId;
    }

    public function setCategoryId(string $categoryId): void
    {
        $this->categoryId = $categoryId;
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
            'categoryId' => $this->categoryId
        ];
    }
}
