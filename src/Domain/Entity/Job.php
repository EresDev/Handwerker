<?php

declare(strict_types=1);

namespace App\Domain\Entity;

use DateTime;

class Job extends Entity
{
    private string $title;
    private string $zipCode;
    private string $city;
    private string $description;
    private DateTime $executionDateTime;
    private Category $category;
    private User $user;

    public function __construct(
        string $uuid,
        string $title,
        string $zipCode,
        string $city,
        string $description,
        DateTime $executionDateTime,
        Category $category,
        User $user
    ) {
        parent::__construct($uuid);

        $this->title = $title;
        $this->zipCode = $zipCode;
        $this->city = $city;
        $this->description = $description;
        $this->executionDateTime = $executionDateTime;
        $this->category = $category;
        $this->user = $user;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getZipCode(): string
    {
        return $this->zipCode;
    }

    public function setZipCode(string $zipCode): void
    {
        $this->zipCode = $zipCode;
    }

    public function getCity(): string
    {
        return $this->city;
    }

    public function setCity(string $city): void
    {
        $this->city = $city;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function getExecutionDateTime(): DateTime
    {
        return $this->executionDateTime;
    }

    public function setExecutionDateTime(DateTime $executionDateTime): void
    {
        $this->executionDateTime = $executionDateTime;
    }

    public function getCategory(): Category
    {
        return $this->category;
    }

    public function setCategory(Category $category): void
    {
        $this->category = $category;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function setUser(User $user): void
    {
        $this->user = $user;
    }

    public function equals(self $job): bool
    {
        return $this->uuid === $job->uuid &&
            $this->title === $job->title &&
            $this->zipCode === $job->zipCode &&
            $this->city === $job->city &&
            $this->executionDateTime === $job->executionDateTime &&
            $this->category->equals($job->category) &&
            $this->user->equals($job->user);
    }

    public function toArray(): array
    {
        return [
            'uuid' => $this->uuid,
            'title' => $this->title,
            'zipCode' => $this->zipCode,
            'city' => $this->city,
            'description' => $this->description,
            'executionDatetime' => $this->executionDateTime->getTimestamp(),
            'category' => $this->category->toArray()
        ];
    }
}
