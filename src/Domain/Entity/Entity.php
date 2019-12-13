<?php

namespace App\Domain\Entity;

abstract class Entity
{
    protected $id;
    protected string $uuid;

    public function getId() : ?int
    {
        return $this->id;
    }

    public function set_id(int $id): void
    {
        $this->id = $id;
    }

    public function getUuid(): string
    {
        return $this->uuid;
    }

    public function setUuid($uuid): void
    {
        $this->uuid = $uuid;
    }
}
