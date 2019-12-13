<?php

namespace App\Domain\Entity;

class User extends Entity
{
    protected string $email;
    protected string $plainPassword;
    protected string $password;
    protected bool $activated = false;
    protected bool $deleted = false;
    protected \DateTime $memberSince;
    protected array $roles;

    public function __construct(string $uuid, string $email, string $password, array $roles)
    {
        parent::__construct($uuid);

        $this->email = $email;
        $this->password = $password;
        $this->roles = $roles;

        $this->activated = false;
        $this->deleted = false;
        $this->memberSince = new \DateTime('now');
    }

    public function getEmail() : string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function setPlainPassword(string $plainPassword): void
    {
        $this->plainPassword = $plainPassword;
    }

    public function getPlainPassword(): string
    {
        return $this->plainPassword;
    }

    public function getPassword() : ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    public function getActivated() : bool
    {
        return $this->activated;
    }

    public function setActivated(bool $active): void
    {
        $this->activated = $active;
    }

    public function getDeleted() : bool
    {
        return $this->deleted;
    }

    public function setDeleted(bool $deleted): void
    {
        $this->deleted = $deleted;
    }

    public function getMemberSince() : \DateTime
    {
        return $this->memberSince;
    }

    public function setMemberSince(\DateTime $memberSince): void
    {
        $this->memberSince = $memberSince;
    }

    public function getRoles() : array
    {
        $roles = $this->roles;
        $roles[] = 'ROLE_USER';
        return array_unique($roles);
    }

    public function setRoles($roles) : void
    {
        $this->roles = $roles;
    }
}
