<?php

namespace App\Infrastructure\Controller;

use App\Domain\Service\Uuid;
use App\Application\UseCase\RegisterUser;
use SimpleBus\SymfonyBridge\Bus\CommandBus;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

class RegisterUserController
{
    private CommandBus $commandBus;
    private Request $request;

    public function __construct(CommandBus $commandBus, RequestStack $requestStack)
    {
        $this->commandBus = $commandBus;
        $this->request = $requestStack->getCurrentRequest();
    }

    public function handleRequest(): JsonResponse {
        $uuid = Uuid::get();
        $command = new RegisterUser(
            $uuid,
            $this->request->get('email', ''),
            $this->request->get('password', '')
        );
        try {
            $this->commandBus->handle($command);
        } catch (\Exception $exception) {

        }
        return new JsonResponse(
            ['userUuid' => $uuid]
        );
    }

}
