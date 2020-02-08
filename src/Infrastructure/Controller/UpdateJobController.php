<?php

declare(strict_types=1);

namespace App\Infrastructure\Controller;

use App\Application\Command\UpdateJobCommand;
use App\Application\CommandHandler\UpdateJobHandler;
use App\Application\Service\Security\Security;
use App\Application\Service\Translator;
use App\Domain\Entity\User;
use App\Domain\Exception\DomainException;
use App\Domain\Exception\ValidationException;
use App\Domain\ValueObject\Uuid;
use App\Infrastructure\Service\Http\ErrorResponseContent;
use App\Infrastructure\Service\Http\FailureResponseContent;
use App\Infrastructure\Service\Http\SuccessResponseContent;
use DateTime;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

class UpdateJobController
{
    private Request $request;
    private Translator $translator;
    private UpdateJobHandler $handler;
    private User $user;

    public function __construct(
        Translator $translator,
        RequestStack $requestStack,
        UpdateJobHandler $handler,
        Security $security
    ) {
        $this->request = $requestStack->getCurrentRequest();
        $this->translator = $translator;
        $this->handler = $handler;
        $this->user = $security->getUser();
    }

    public function handleRequest(): JsonResponse
    {
        $executionTimestamp = (int)$this->request->get('executionDateTime', 0);

        try {
            $command = new UpdateJobCommand(
                Uuid::createFrom($this->request->get('uuid', '')),
                $this->request->get('title', ''),
                $this->request->get('zipCode', ''),
                $this->request->get('city', ''),
                $this->request->get('description', ''),
                $this->getDateTimeFrom($executionTimestamp),
                Uuid::createFrom($this->request->get('categoryId', ''))
            );

            $this->handler->handle($command);
        } catch (ValidationException $exception) {
            return JsonResponse::create(
                new FailureResponseContent($exception->getViolations()),
                422
            );
        } catch (DomainException $exception) {
            return JsonResponse::create(
                new ErrorResponseContent(
                    $this->translator->translate($exception->getViolation())
                ),
                422
            );
        }

        return JsonResponse::create(
            new SuccessResponseContent(null),
            204
        );
    }

    private function getDateTimeFrom($timestamp): DateTime
    {
        return (new DateTime())
            ->setTimestamp(
                $timestamp
            );
    }
}
