<?php

namespace Domain\Entity;

use App\Domain\Entity\Entity;
use App\Domain\Entity\User;

class Job extends Entity
{
    private string $title;
    private string $zipCode;
    private string $city;
    private string $description;
    private \DateTime $execution;
    private Category $category;
    private User $poster;

    public function __construct(
        string $uuid,
        string $title,
        string $zipCode,
        string $city,
        string $description,
        \DateTime $execution,
        Category $category,
        User $poster
    ) {
        parent::__construct($uuid);

        $this->title = $title;
        $this->zipCode = $zipCode;
        $this->city = $city;
        $this->description = $description;
        $this->execution = $execution;
        $this->category = $category;
        $this->poster = $poster;
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

    public function getExecution(): \DateTime
    {
        return $this->execution;
    }

    public function setExecution(\DateTime $execution): void
    {
        $this->execution = $execution;
    }

    public function getCategory(): Category
    {
        return $this->category;
    }

    public function setCategory(Category $category): void
    {
        $this->category = $category;
    }

    public function getPoster(): User
    {
        return $this->poster;
    }

    public function setPoster(User $poster): void
    {
        $this->poster = $poster;
    }
}
