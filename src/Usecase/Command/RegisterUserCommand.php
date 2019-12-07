<?php

namespace App\Usecase\Command;

use Ramsey\Uuid\Uuid;

class RegisterUserCommand extends Command
{
    private $uuid;
    private $email;
    private $password;

    public function __construct(Uuid $uuid, string $email, string $password)
    {
        $this->uuid = $uuid;
        $this->email = $email;
        $this->password = $password;
    }

    public function getUuid(): Uuid
    {
        return $this->uuid;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getContent(): array
    {
        return [
            'uuid' => $this->uuid,
            'email' => $this->email,
            'password' => $this->password
        ];
    }

}
