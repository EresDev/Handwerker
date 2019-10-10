<?php

namespace App\ThirdParty\Security\Symfony;

use App\Domain\Entity\User;
use Symfony\Component\Security\Core\User\UserInterface;

class SecurityUser extends User implements UserInterface
{
    public function getSalt()
    {
        return '';
    }

    public function eraseCredentials()
    {
        $this->setPassword('');
    }
}
