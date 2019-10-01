<?php

namespace Domain\Entity;

use App\Domain\Entity\User;

class UserRole implements \JsonSerializable
{
    private $id;
    private $user;
    private $role;

    public function getId() : int
    {
        return $this->id;
    }

    public function setId($id): void
    {
        $this->id = $id;
    }

    public function getUser() : User
    {
        return $this->user;
    }

    public function setUser(User $user): void
    {
        $this->user = $user;
    }

    public function getRole() : Role
    {
        return $this->role;
    }

    public function setRole(Role $role): void
    {
        $this->role = $role;
    }

    public function jsonSerialize() : array
    {
        return [
            'id' => $this->getId(),
            'userId' => $this->getUserId(),
            'roleId' => $this->getRoleId()
        ];
    }

}
