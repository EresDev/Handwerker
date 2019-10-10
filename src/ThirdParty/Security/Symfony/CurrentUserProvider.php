<?php

namespace App\ThirdParty\Security\Symfony;

use App\Domain\Entity\User;
use App\ThirdParty\Security\Symfony\SecurityUser;
use App\ThirdParty\Persistence\Doctrine\Repository\UserRepositoryImpl;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

final class CurrentUserProvider
{
    private $tokenStorage;
    private $userRepo;
    private $currentUser; // cached to prevent querying multiple times

    public function __construct(TokenStorageInterface $tokenStorage, UserRepositoryImpl $userRepo)
    {
        $this->tokenStorage = $tokenStorage;
        $this->userRepo = $userRepo;
    }
    public function get(): ?User
    {
        if (!$this->currentUser) {
            $this->currentUser = $this->fromToken($this->tokenStorage->getToken());
        }
        return $this->currentUser;
    }
    public function fromToken(TokenInterface $token): ?User
    {
        if (!$token || !$token->getUser() instanceof SecurityUser) {
            return null;
        }
        return $this->userRepo->findBy('email', $token->getUsername());
    }
}
