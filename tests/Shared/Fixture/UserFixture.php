<?php

declare(strict_types=1);

namespace App\Tests\Shared\Fixture;

use App\Application\Service\Security\Role;
use App\Domain\Entity\User;
use App\Domain\ValueObject\Uuid;

abstract class UserFixture
{
    public const UUID = '3e279073-ca26-41d8-94e8-002e9dc36f9b';
    public const EMAIL = 'auth_user2@eresdev.com';
    public const PLAIN_PASSWORD = 'somePassword1145236';
    public const PASSWORD = '$2y$10$SQhOdCHPaKt6BNj7tLtvX.TxlzVVWP6Ec.MRnR5ZKm4YffmbkMlqG';
    public const ROLE = Role::USER;

    public static function getInstance(): User
    {
        return new User(
            Uuid::createFrom(self::UUID),
            self::EMAIL,
            self::PASSWORD,
            [self::ROLE]
        );
    }
}
