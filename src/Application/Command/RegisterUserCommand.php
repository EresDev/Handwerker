<?php

declare(strict_types=1);

namespace App\Application\Command;

class RegisterUserCommand extends Command
{
    private string $uuid;
    private string $email;
    private string $password;

    public function __construct(string $uuid, string $email, string $password)
    {
        $this->uuid = $uuid;
        $this->email = $email;
        $this->password = $password;
    }

    public function getUuid(): string
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
