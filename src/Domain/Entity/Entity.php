<?php

namespace App\Domain\Entity;

abstract class Entity
{
    protected $id;
    protected $uuid;

    public function getId() : ?int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getUuid()
    {
        return $this->uuid;
    }

    public function setUuid($uuid): void
    {
        $this->uuid = $uuid;
    }
}
