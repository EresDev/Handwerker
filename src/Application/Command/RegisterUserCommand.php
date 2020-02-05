<?php

declare(strict_types=1);

namespace App\Application\Command;

use App\Domain\ValueObject\Uuid;

class RegisterUserCommand
{
    private Uuid $uuid;
    private string $email;
    private string $password;

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

    public function __toString(): string
    {
        return print_r(
            [
                'uuid' => $this->uuid,
                'email' => $this->email,
                'password' => $this->password
            ],
            true
        );
    }
}
