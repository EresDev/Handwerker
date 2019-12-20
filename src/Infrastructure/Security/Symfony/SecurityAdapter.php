<?php

declare(strict_types=1);

namespace App\Infrastructure\Security\Symfony;

use App\Application\Service\Security\Security;
use App\Domain\Entity\User;
use Symfony\Component\Security\Core\Security as SymfonySecurity;

class SecurityAdapter implements Security
{
    private SymfonySecurity $security;

    public function __construct(SymfonySecurity $security)
    {
        $this->security = $security;
    }

    public function getUser(): User
    {
        return $this->security->getUser()->getEntity();
    }
}
