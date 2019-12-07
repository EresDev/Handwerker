<?php

namespace App\Controller;


use App\Domain\Entity\User;
use App\Domain\Repository\SaveRepository;
use App\Domain\Security\Role;
use App\Domain\Service\Http\PostParameter;
use App\Domain\Service\PasswordEncoder;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Core\Encoder\NativePasswordEncoder;

class CreateUserController
{
    private PostParameter $postParameter;
    private SaveRepository $saverRepository;
    private NativePasswordEncoder $passworEncoder;

    public function __construct(
        PostParameter $postParameter,
        SaveRepository $saverRepository,
        NativePasswordEncoder $passwordEncoder
    ) {
        $this->postParameter = $postParameter;
        $this->saverRepository = $saverRepository;
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

        $this->saverRepository->save($user);

        return new JsonResponse($user, 200);
    }
}
