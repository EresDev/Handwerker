<?php

namespace App\ThirdParty\Security\Symfony;

use App\ThirdParty\Security\Symfony\CurrentUserProvider;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Guard\Authenticator\AbstractFormLoginAuthenticator;

class LoginFormAuthenticator extends AbstractFormLoginAuthenticator
{
    private $currentUserProvider;

    public function __construct(CurrentUserProvider $currentUserProvider)
    {
        $this->currentUserProvider = $currentUserProvider;
    }
    public function supports(Request $request): bool
    {
        // ...
    }
    public function getCredentials(Request $request)
    {
        // ...
    }
    public function getUser($credentials, UserProviderInterface $userProvider): UserInterface
    {
        // ...
        try {
            $user = $userProvider->loadUserByUsername($credentials['email']);
        } catch (UsernameNotFoundException $exception) {
            throw new CustomUserMessageAuthenticationException('Email could not be found.');
        }
        return $user;
    }
    public function checkCredentials($credentials, UserInterface $user): bool
    {
        // ...
    }
    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
    {
        $user = $this->currentUserProvider->fromToken($token);
        // ...
    }
    public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
    {
        // ...
    }
    public function start(Request $request, AuthenticationException $authException = null)
    {
        // ...
    }
    protected function getLoginUrl()
    {
        // ...
    }
}
