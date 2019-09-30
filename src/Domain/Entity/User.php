<?php

namespace App\Domain\Entity;

class User implements \JsonSerializable
{
    private $email;
    private $password;
    private $activated;
    private $deleted;
    private $memberSince;

    public function __construct(
        string $email,
        string $password,
        bool $activated,
        bool $deleted,
        \DateTime $memberSince
    ){
        $this->setEmail($email);
        $this->setPassword($password);
        $this->setActivated($activated);
        $this->setDeleted($deleted);
        $this->setMemberSince($memberSince);
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

    public function getRoles() : array
    {
        return ['ROLE_USER'];
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
