<?php

namespace App\Controller;

use App\Usecase\Command\RegisterUserCommand;
use Ramsey\Uuid\Uuid;
use SimpleBus\SymfonyBridge\Bus\CommandBus;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

class RegisterUserController
{
    private CommandBus $commandBus;
    private Request $request;

    /**
     * RegisterUserController constructor.
     * @param CommandBus $commandBus
     * @param Request $request
     */
    public function __construct(CommandBus $commandBus, RequestStack $requestStack)
    {
        $this->commandBus = $commandBus;
        $this->request = $requestStack->getCurrentRequest();
    }

    public function handleRequest(): JsonResponse {
        $uuid = Uuid::uuid1();
        $command = new RegisterUserCommand(
            $uuid,
            $this->request->get('email', ''),
            $this->request->get('password', '')
        );
        try {
            $this->commandBus->handle($command);
        } catch (\Exception $exception) {

        }
        return new JsonResponse(
            ['userUuid' => $uuid->toString()]
        );
    }

}
