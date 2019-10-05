<?php

namespace App\Domain\Entity;

class Role implements \JsonSerializable
{
    private $id;
    private $title;

    public function getId() : int
    {
        return $this->id;
    }

    public function setId($id): void
    {
        $this->id = $id;
    }

    public function getTitle() : string
    {
        return $this->title;
    }

    public function setTitle($title): void
    {
        $this->title = $title;
    }

    public function jsonSerialize() : array
    {
        return [
            'id' => $this->getId(),
            'title' => $this->getTitle()
        ];
    }
}
