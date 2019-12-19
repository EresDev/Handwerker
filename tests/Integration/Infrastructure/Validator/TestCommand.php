<?php

declare(strict_types=1);

namespace App\Tests\Integration\Infrastructure\Validator;

class TestCommand
{
    private string $uuid;
    private string $email;

    public function __construct(string $uuid, string $email)
    {
        $this->uuid = $uuid;
        $this->email = $email;
    }

    public function getUuid(): string
    {
        return $this->uuid;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function __toString(): string
    {
        return print_r(
            ['uuid' => $this->uuid, 'email'=> $this->email],
            true
        );
    }
}
