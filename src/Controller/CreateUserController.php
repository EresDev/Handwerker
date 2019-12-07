<?php

namespace App\Controller;


use App\Domain\Entity\User;
use App\Domain\Repository\RelationalSaverRepository;
use App\Domain\Security\Role;
use App\Domain\Service\Http\PostParameter;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Core\Encoder\NativePasswordEncoder;

class CreateUserController
{
    private PostParameter $postParameter;
    private $relationalSaverRepository;
    private $passworEncoder;

    public function __construct(
        PostParameter $postParameter,
        RelationalSaverRepository $relationalSaverRepository,
        NativePasswordEncoder $passwordEncoder
    ) {
        $this->postParameter = $postParameter;
        $this->relationalSaverRepository = $relationalSaverRepository;
        $this->passworEncoder = $passwordEncoder;
    }

    public function handleRequest() : JsonResponse
    {
        $user = new User();
        $user->setId(33);
        $user->setEmail($this->postParameter->get('email'));

        $encodedPassword = $this->passworEncoder->encodePassword(
            $this->postParameter->get('password'),
            $user->getSalt()
        );

        $user->setPassword($encodedPassword);
        $user->setRoles([Role::USER]);
        //TODO: VALIDATE USER

        $this->relationalSaverRepository->save($user);

        return new JsonResponse($user, 200);
    }
}
