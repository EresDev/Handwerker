<?php

namespace App\Domain\Entity;

class Category extends Entity
{
    private string $name;
    private string $imageUri;

    public function __construct(string $uuid, string $name, string $imageUri)
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
}
