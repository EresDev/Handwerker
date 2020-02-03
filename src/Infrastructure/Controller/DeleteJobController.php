<?php

declare(strict_types=1);

namespace App\Infrastructure\Controller;

use App\Application\Command\DeleteJobCommand;
use App\Application\CommandHandler\DeleteJobHandler;
use App\Application\Service\Security\Security;
use App\Application\Service\Translator;
use App\Domain\Entity\User;
use App\Domain\Exception\TempDomainException;
use App\Infrastructure\Service\Http\ErrorResponseContent;
use App\Infrastructure\Service\Http\SuccessResponseContent;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

class DeleteJobController
{
    private Request $request;
    private Translator $translator;
    private User $user;
    private DeleteJobHandler $handler;

    public function __construct(
        RequestStack $requestStack,
        Translator $translator,
        Security $security,
        DeleteJobHandler $handler
    ) {
        $this->request = $requestStack->getCurrentRequest();
        $this->translator = $translator;
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
        } catch (TempDomainException $exception) {
            return JsonResponse::create(
                new ErrorResponseContent(
                    $this->translator->translate($exception->getViolation())
                ),
                404
            );
        }

        return JsonResponse::create(
            new SuccessResponseContent(null),
            204
        );
    }
}
