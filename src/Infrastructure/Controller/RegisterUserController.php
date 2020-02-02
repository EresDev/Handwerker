<?php

declare(strict_types=1);

namespace App\Infrastructure\Controller;

use App\Application\Command\RegisterUserCommand;
use App\Application\CommandHandler\RegisterUserHandler;
use App\Application\Service\Uuid;
use App\Domain\Exception\TempValidationException;
use App\Infrastructure\Service\Http\FailureResponseContent;
use App\Infrastructure\Service\Http\SuccessResponseContent;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

class RegisterUserController
{
    private Request $request;
    private Uuid $uuidGenerator;
    private RegisterUserHandler $handler;

    public function __construct(
        RequestStack $requestStack,
        Uuid $uuidGenerator,
        RegisterUserHandler $handler
    ) {
        $this->request = $requestStack->getCurrentRequest();
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
        } catch (TempValidationException $exception) {
            return JsonResponse::create(
                new FailureResponseContent($exception->getViolations()),
                422
            );
        }

        return JsonResponse::create(
            new SuccessResponseContent(['user' => ['uuid' => $uuid]]),
            201
        );
    }
}
