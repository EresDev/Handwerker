<?php

namespace App\Domain\Entity;

class Role extends Entity implements \JsonSerializable
{
    private $title;

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

    public function __toString() : string
    {
        return $this->title;
    }
}
