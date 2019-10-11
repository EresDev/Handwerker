<?php

namespace App\ThirdParty\Security\Symfony;

use App\Domain\Entity\User;
use Symfony\Component\Security\Core\User\UserInterface;

class SecurityUser implements UserInterface
{
    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function getId() : ?int
    {
        return $this->user->getId();
    }

    public function setId(int $id): void
    {
        $this->user->setId($id);
    }

    public function getEmail() : string
    {
        return $this->user->getEmail();
    }

    public function setEmail(string $email): void
    {
        $this->user->setEmail($email);
    }

    public function getPassword() : ?string
    {
        return $this->user->getPassword();
    }

    public function setPassword(string $password): void
    {
        $this->user->setPassword($password);
    }

    public function getActivated() : bool
    {
        return $this->user->getActivated();
    }

    public function setActivated(bool $active): void
    {
        $this->user->setActivated($active);
    }

    public function getDeleted() : bool
    {
        return $this->user->getDeleted();
    }

    public function setDeleted(bool $deleted): void
    {
        $this->user->setDeleted($deleted);
    }

    public function getMemberSince() : \DateTime
    {
        return $this->user->getMemberSince();
    }

    public function setMemberSince(\DateTime $memberSince): void
    {
        $this->user->setMemberSince($memberSince);
    }

    public function getRoles() : array
    {
        return $this->user->getRoles();
    }

    public function setRoles($roles) : void
    {
        $this->user->setRoles($roles);
    }

    public function getUsername() : string
    {
        return $this->user->getEmail();
    }

    public function getSalt() : string
    {
        return $this->user->getSalt();
    }

    public function eraseCredentials()
    {
        $this->setPassword('');
    }
}
