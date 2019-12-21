<?php

declare(strict_types=1);

namespace App\Application\Service\Security;

abstract class Role
{
    public const ANONYMOUS = 'IS_AUTHENTICATED_ANONYMOUSLY';
    public const USER = 'ROLE_USER';
    public const ADMIN = 'ROLE_ADMIN';
}
