<?php

namespace App\Infrastructure\Controller;

use App\Application\Command\RegisterUserCommand;
use App\Domain\Exception\ValidationException;
use App\Application\Service\Uuid;
use SimpleBus\SymfonyBridge\Bus\CommandBus;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

class RegisterUserController
{
    private CommandBus $commandBus;
    private Request $request;
    private Uuid $uuidGenerator;

    public function __construct(CommandBus $commandBus, RequestStack $requestStack, Uuid $uuidGenerator) {
        $this->commandBus = $commandBus;
        $this->request = $requestStack->getCurrentRequest();
        $this->uuidGenerator = $uuidGenerator;
    }

    public function handleRequest(): JsonResponse {
        $uuid = $this->uuidGenerator->generate();
        $command = new RegisterUserCommand(
            $uuid,
            $this->request->get('email', ''),
            $this->request->get('password', '')
        );
        try {
            $this->commandBus->handle($command);
        } catch (ValidationException $exception) {
            return new JsonResponse($exception->getMessagesForEndUser(), 422);
        }

        return new JsonResponse(['uuid' => $uuid], 200);
    }

}
