<?php

namespace App\ThirdParty\Security\Symfony;

use Symfony\Bridge\Doctrine\Security\User\EntityUserProvider;
use Symfony\Bridge\Doctrine\Security\User\UserLoaderInterface;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;
use App\ThirdParty\Persistence\Doctrine\Repository\UserRepositoryImpl;

class UserLoader extends EntityUserProvider implements UserLoaderInterface
{
    private $singleEntityFinder;

    public function __construct(UserRepositoryImpl $userRepositoryImpl)
    {
        $this->singleEntityFinder = $userRepositoryImpl;
    }

    public function loadUserByUsername($username)
    {
        if (null === ($user = $this->singleEntityFinder->findBy('email', $username))) {
            throw new BadCredentialsException(sprintf('No user found for "%s"', $username));
        }

        return new SecurityUser($user);
    }
}
