<?php

namespace App\Controller;

use App\Usecase\Command\RegisterUserCommand;
use Ramsey\Uuid\Uuid;
use SimpleBus\SymfonyBridge\Bus\CommandBus;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class RegisterUserController
{
    public function handleRequest(
        Request $request,
        CommandBus $commandBus
    ): JsonResponse {

        $command = new RegisterUserCommand(
            Uuid::uuid1(),
            $request->get('email', ''),
            $request->get('password', '')
        );
        try {
            $commandBus->handle($command);
        } catch (\Exception $exception) {

        }
        return new JsonResponse();
    }

}
