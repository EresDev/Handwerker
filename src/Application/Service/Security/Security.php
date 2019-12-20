<?php

declare(strict_types=1);

namespace App\Application\Service\Security;

use App\Domain\Entity\User;

interface Security
{
    public function getUser(): User;
}
