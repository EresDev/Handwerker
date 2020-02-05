<?php

declare(strict_types=1);

namespace App\Domain\Entity;

use App\Domain\ValueObject\Uuid;

class Category extends Entity
{
    private string $name;
    private string $imageUri;

    public function __construct(Uuid $uuid, string $name, string $imageUri)
    {
        parent::__construct($uuid);

        $this->name = $name;
        $this->imageUri = $imageUri;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getImageUri(): string
    {
        return $this->imageUri;
    }

    public function setImageUri(string $imageUri): void
    {
        $this->imageUri = $imageUri;
    }

    public function equals(self $category): bool
    {
        return $this->uuid === $category->uuid &&
            $this->name === $category->name &&
            $this->imageUri === $category->imageUri;
    }

    public function toArray(): array
    {
        return [
            'uuid' => $this->uuid,
            'name' => $this->name
        ];
    }
}
