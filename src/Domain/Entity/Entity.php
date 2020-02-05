<?php

declare(strict_types=1);

namespace App\Domain\Entity;

use App\Domain\ValueObject\Uuid;

abstract class Entity
{
    protected $id;
    protected Uuid $uuid;

    public function __construct(Uuid $uuid)
    {
        $this->uuid = $uuid;
    }

    public function getId() : ?int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getUuid(): Uuid
    {
        return $this->uuid;
    }

    public function setUuid(string $uuid): void
    {
        $this->uuid = $uuid;
    }
}
