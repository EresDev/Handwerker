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
use DateTime;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RequestStack;

class UpdateJobController extends BaseController
{
    private UpdateJobHandler $handler;
    private User $user;

    public function __construct(
        Translator $translator,
        RequestStack $requestStack,
        UpdateJobHandler $handler,
        Security $security
    ) {
        parent::__construct($translator, $requestStack);

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
            return $this->createResponseFromArray(
                $exception->getMessages(),
                422
            );
        } catch (DomainException $exception) {
            return $this->createTranslatedResponseFromArray(
                $exception->getViolations(),
                422
            );
        }

        return $this->createEmptyResponse(204);
    }

    private function getDateTimeFrom($timestamp): DateTime
    {
        return (new DateTime())
            ->setTimestamp(
                $timestamp
            );
    }
}
