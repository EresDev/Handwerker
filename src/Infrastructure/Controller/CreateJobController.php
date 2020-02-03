<?php

declare(strict_types=1);

namespace App\Infrastructure\Controller;

use App\Application\Command\CreateJobCommand;
use App\Application\CommandHandler\CreateJobHandler;
use App\Application\Service\Security\Security;
use App\Application\Service\Translator;
use App\Application\Service\Uuid;
use App\Domain\Entity\User;
use App\Domain\Exception\TempDomainException;
use App\Domain\Exception\TempValidationException;
use App\Infrastructure\Service\Http\ErrorResponseContent;
use App\Infrastructure\Service\Http\FailureResponseContent;
use App\Infrastructure\Service\Http\SuccessResponseContent;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

class CreateJobController
{
    private Request $request;
    private Uuid $uuidGenerator;
    private Translator $translator;
    private CreateJobHandler $handler;
    private User $user;

    public function __construct(
        RequestStack $requestStack,
        Uuid $uuidGenerator,
        Translator $translator,
        CreateJobHandler $handler,
        Security $security
    ) {
        $this->request = $requestStack->getCurrentRequest();
        $this->uuidGenerator = $uuidGenerator;
        $this->translator = $translator;
        $this->handler = $handler;
        $this->user = $security->getUser();
    }

    public function handleRequest(): JsonResponse
    {
        $uuid = $this->uuidGenerator->generate();

        $executionTimestamp = (int)$this->request->get('executionDateTime', 0);
        $command = new CreateJobCommand(
            $uuid,
            $this->request->get('title', ''),
            $this->request->get('zipCode', ''),
            $this->request->get('city', ''),
            $this->request->get('description', ''),
            $this->getDateTimeFrom($executionTimestamp),
            $this->request->get('categoryId', ''),
            $this->user
        );

        try {
            $this->handler->handle($command);
        } catch (TempValidationException $exception) {
            return JsonResponse::create(
                new FailureResponseContent($exception->getViolations()),
                422
            );
        } catch (TempDomainException $exception) {
            return JsonResponse::create(
                new ErrorResponseContent(
                    $this->translator->translate($exception->getViolation())
                ),
                422
            );
        }

        return JsonResponse::create(
            new SuccessResponseContent(['job' => ['uuid' => $uuid]]),
            201
        );
    }

    private function getDateTimeFrom($timestamp): \DateTime
    {
        return (new \DateTime())
            ->setTimestamp(
                $timestamp
            );
    }
}
