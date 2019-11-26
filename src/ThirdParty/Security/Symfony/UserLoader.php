<?php

namespace App\ThirdParty\Security\Symfony;

use App\Domain\Repository\UnitReadRepository;
use Symfony\Bridge\Doctrine\Security\User\EntityUserProvider;
use Symfony\Bridge\Doctrine\Security\User\UserLoaderInterface;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;


class UserLoader extends EntityUserProvider implements UserLoaderInterface
{
    private $unitReadRepository;

    public function __construct(UnitReadRepository $unitReadRepository)
    {
        $this->unitReadRepository = $unitReadRepository;
    }

    public function loadUserByUsername($username)
    {
        if (null === ($user = $this->unitReadRepository->getBy('email', $username))) {
            throw new BadCredentialsException(sprintf('No user found for "%s"', $username));
        }

        return new UserAdapter($user);
    }
}
