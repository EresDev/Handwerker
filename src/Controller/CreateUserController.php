<?php

namespace App\Controller;

use App\Domain\Entity\Role;
use App\Domain\Entity\User;
use App\Domain\Repository\RelationalSaverRepository;
use App\Domain\Repository\SaveRepository;
use App\Domain\Service\Http\PostParameter;
use App\Infrastructure\Security\Symfony\UserAdapter;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Core\Encoder\NativePasswordEncoder;

class CreateUserController
{
    private $postParameter;
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

        $role = $this->relationalSaverRepository->getBy(
            'title',
            'USER',
            Role::class
        );
        $user->setRoles([$role]);
        //TODO: VALIDATE USER

        $this->relationalSaverRepository->save($user);

        return new JsonResponse($user, 200);
    }
}
