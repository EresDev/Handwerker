<?php

namespace App\Infrastructure\Security\Symfony;

use App\Domain\Entity\User;
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
        if (null === ($user = $this->unitReadRepository->getBy('email', $username, User::class))) {
            throw new BadCredentialsException(sprintf('No user found for "%s"', $username));
        }

        return new UserAdapter($user);
    }
}
