<?php

namespace App\Domain\Entity;

abstract class Entity
{
    protected $id;

    public function getId() : int
    {
        return $this->id;
    }

    public function setId($id): void
    {
        $this->id = $id;
    }
}
