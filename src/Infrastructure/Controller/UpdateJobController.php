<?php

declare(strict_types=1);

namespace App\Infrastructure\Controller;

use App\Application\Command\CreateJobCommand;
use App\Application\Command\UpdateJobCommand;
use App\Application\CommandHandler\CreateJobHandler;
use App\Application\CommandHandler\UpdateJobHandler;
use App\Application\Service\Security\Security;
use App\Application\Service\Uuid;
use App\Domain\Entity\User;
use App\Domain\Exception\ValidationException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

class UpdateJobController
{
    private Request $request;
    private UpdateJobHandler $handler;
    private User $user;

    public function __construct(
        RequestStack $requestStack,
        UpdateJobHandler $handler,
        Security $security
    ) {
        $this->request = $requestStack->getCurrentRequest();
        $this->handler = $handler;
        $this->user = $security->getUser();
    }

    public function handleRequest(): JsonResponse
    {
        $executionTimestamp = (int)$this->request->get('executionDateTime', 0);
        $command = new UpdateJobCommand(
            $this->request->get('uuid', ''),
            $this->request->get('title', ''),
            $this->request->get('zipCode', ''),
            $this->request->get('city', ''),
            $this->request->get('description', ''),
            $this->getDateTimeFrom($executionTimestamp),
            $this->request->get('categoryId', '')
        );

        try {
            $this->handler->handle($command);
        } catch (ValidationException $exception) {
            return new JsonResponse($exception->getMessagesForEndUser(), 422);
        }

        return new JsonResponse('', 204);
    }

    private function getDateTimeFrom($timestamp): \DateTime
    {
        return (new \DateTime())
            ->setTimestamp(
                $timestamp
            );
    }
}
