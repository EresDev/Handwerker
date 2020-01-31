<?php

declare(strict_types=1);

namespace App\Infrastructure\Controller;

use App\Application\Command\RegisterUserCommand;
use App\Application\CommandHandler\RegisterUserHandler;
use App\Application\Service\Translator;
use App\Application\Service\Uuid;
use App\Domain\Exception\DuplicateUuidException;
use App\Domain\Exception\ValidationException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RequestStack;

class RegisterUserController extends BaseController
{
    private Uuid $uuidGenerator;
    private RegisterUserHandler $handler;

    public function __construct(
        Translator $translator,
        RequestStack $requestStack,
        Uuid $uuidGenerator,
        RegisterUserHandler $handler
    ) {
        parent::__construct($translator, $requestStack);
        $this->uuidGenerator = $uuidGenerator;
        $this->handler = $handler;
    }

    public function handleRequest(): JsonResponse
    {
        $uuid = $this->uuidGenerator->generate();
        $command = new RegisterUserCommand(
            $uuid,
            $this->request->get('email', ''),
            $this->request->get('password', '')
        );

        try {
            $this->handler->handle($command);
        } catch (ValidationException $exception) {
            return $this->createTranslatedResponseFromArray(
                $exception->getMessages(),
                422
            );
        }

        return $this->createResponseFromArray(['uuid' => $uuid], 201);
    }
}
