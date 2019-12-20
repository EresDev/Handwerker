<?php

declare(strict_types=1);

namespace App\Tests\Shared\Fixture;

use App\Application\Service\Security\Role;

abstract class UserFixture
{
    public const UUID = '3e279073-ca26-41d8-94e8-002e9dc36f9b';
    public const EMAIL = 'auth_user2@eresdev.com';
    public const PLAIN_PASSWORD = 'somePassword1145236';
    public const ROLE = Role::USER;
}
