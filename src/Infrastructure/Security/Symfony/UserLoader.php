<?php

declare(strict_types=1);

namespace App\Infrastructure\Security\Symfony;

use App\Domain\Repository\User\UserFinder;
use Symfony\Bridge\Doctrine\Security\User\EntityUserProvider;
use Symfony\Bridge\Doctrine\Security\User\UserLoaderInterface;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;

class UserLoader extends EntityUserProvider implements UserLoaderInterface
{
    private $userFinder;

    public function __construct(UserFinder $userFinder)
    {
        $this->userFinder = $userFinder;
    }

    public function loadUserByUsername($username)
    {
        if (null === ($user = $this->userFinder->findOneBy('email', $username))) {
            throw new BadCredentialsException(sprintf('No user found for "%s"', $username));
        }

        return new UserAdapter($user);
    }
}
