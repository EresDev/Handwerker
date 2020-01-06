<?php

declare(strict_types=1);

namespace App\Infrastructure\Controller;

use App\Application\Command\DeleteJobCommand;
use App\Application\CommandHandler\DeleteJobHandler;
use App\Application\Service\Security\Security;
use App\Domain\Entity\User;
use App\Domain\Exception\ValidationException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

class DeleteJobController
{
    private Request $request;
    private User $user;
    private DeleteJobHandler $handler;

    public function __construct(
        RequestStack $requestStack,
        Security $security,
        DeleteJobHandler $handler
    ) {
        $this->request = $requestStack->getCurrentRequest();
        $this->user = $security->getUser();
        $this->handler = $handler;
    }

    public function handleRequest(): JsonResponse
    {
        $query = new DeleteJobCommand(
            $this->request->get('uuid', ''),
            $this->user
        );

        try {
            $this->handler->handle($query);
        } catch (ValidationException $exception) {
            return new JsonResponse($exception->getMessagesForEndUser(), 404);
        }

        return new JsonResponse(null, 204);
    }
}
