<?php

namespace App\Domain\Entity;

use Doctrine\Common\Collections\Collection;
use Symfony\Component\Security\Core\User\UserInterface;

class User implements \JsonSerializable, UserInterface
{
    private $id;
    private $email;
    private $password;
    private $activated;
    private $deleted;
    private $memberSince;
    private $roles;

    public function getId() : int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getEmail() : string
    {
        return $this->email;
    }

    public function setEmail($email): void
    {
        $this->email = $email;
    }

    public function getPassword() : ?string
    {
        return $this->password;
    }

    public function setPassword($password): void
    {
        $this->password = $password;
    }

    public function getActivated() : bool
    {
        return $this->activated;
    }

    public function setActivated($active): void
    {
        $this->activated = $active;
    }

    public function getDeleted() : bool
    {
        return $this->deleted;
    }

    public function setDeleted($deleted): void
    {
        $this->deleted = $deleted;
    }

    public function getMemberSince() : \DateTime
    {
        return $this->memberSince;
    }

    public function setMemberSince($memberSince): void
    {
        $this->memberSince = $memberSince;
    }

    public function getRoles()
    {
        foreach ($this->roles->getIterator() as $role) {
            $_roles[] = $role->getTitle();
        }
        return $_roles;
    }

    public function setRoles(Collection $roles) : void
    {
        $this->roles = $roles;
    }

    public function equals(self $user): bool
    {
        return
            $this->getId() === $user->getId() &&
            $this->getEmail() === $user->getEmail() &&
            $this->getActivated() === $user->getActivated() &&
            $this->getDeleted() === $user->getDeleted() &&
            $this->getMemberSince() === $user->getMemberSince();
    }

    public function getUsername() : string
    {
        return $this->getEmail();
    }

    public function getSalt() : ?string
    {
        return '';
    }

    public function eraseCredentials() : void
    {
        $this->setPassword('');
    }

    public function jsonSerialize() : array
    {
        return [
            'id' => $this->getId(),
            'email' => $this->getEmail(),
            'activated' => $this->getActivated(),
            'memberSince' => $this->getMemberSince()
        ];
    }
}
