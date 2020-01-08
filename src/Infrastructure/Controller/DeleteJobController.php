<?php

declare(strict_types=1);

namespace App\Infrastructure\Controller;

use App\Application\Command\DeleteJobCommand;
use App\Application\CommandHandler\DeleteJobHandler;
use App\Application\Service\Security\Security;
use App\Application\Service\Translator;
use App\Domain\Entity\User;
use App\Domain\Exception\ValidationException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RequestStack;

class DeleteJobController extends BaseController
{
    private User $user;
    private DeleteJobHandler $handler;

    public function __construct(
        Translator $translator,
        RequestStack $requestStack,
        Security $security,
        DeleteJobHandler $handler
    ) {
        parent::__construct($translator, $requestStack);

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
            return $this->createTranslatedResponse(
                $exception->getMessagesForEndUser()[0],
                404
            );
        }

        return $this->createEmptyResponse(204);
    }
}
