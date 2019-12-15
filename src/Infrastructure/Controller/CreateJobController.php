<?php

namespace App\Infrastructure\Controller;

use App\Application\Service\Uuid;
use App\Domain\Entity\User;
use App\Domain\Exception\ValidationException;
use App\Application\Command\CreateJobCommand;
use App\Application\CommandHandler\CreateJobHandler;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

class CreateJobController
{
    private Request $request;
    private Uuid $uuidGenerator;
    private CreateJobHandler $handler;
    private User $user;

    public function __construct(
        RequestStack $requestStack,
        Uuid $uuidGenerator,
        CreateJobHandler $handler//,
        //User $user
    ) {
        $this->request = $requestStack->getCurrentRequest();
        $this->uuidGenerator = $uuidGenerator;
        $this->handler = $handler;
        //$this->user = $user;
    }

    public function handleRequest(): JsonResponse
    {
        $uuid = $this->uuidGenerator->generate();
        $command = new CreateJobCommand(
            $uuid,
            $this->request->get('title', ''),
            $this->request->get('zipCode', ''),
            $this->request->get('city', ''),
            $this->request->get('description', ''),
            $this->request->get('executionDateTime', ''),
            $this->request->get('categoryId', ''),
            '3e279073-ca26-41d8-94e8-002e9dc36f9b'//$this->user->getUuid()
        );

        try {
            $this->handler->handle($command);
        } catch (ValidationException $exception) {
            return new JsonResponse($exception->getMessagesForEndUser(), 422);
        }

        return new JsonResponse(['uuid' => $uuid], 201);
    }
}
