<?php

declare(strict_types=1);

namespace App\Infrastructure\Controller;

use App\Application\Command\CreateJobCommand;
use App\Application\CommandHandler\CreateJobHandler;
use App\Application\Service\Security\Security;
use App\Application\Service\Translator;
use App\Application\Service\Uuid;
use App\Domain\Entity\User;
use App\Domain\Exception\DomainException;
use App\Domain\Exception\ValidationException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RequestStack;

class CreateJobController extends BaseController
{
    private Uuid $uuidGenerator;
    private CreateJobHandler $handler;
    private User $user;

    public function __construct(
        Translator $translator,
        RequestStack $requestStack,
        Uuid $uuidGenerator,
        CreateJobHandler $handler,
        Security $security
    ) {
        parent::__construct($translator, $requestStack);

        $this->uuidGenerator = $uuidGenerator;
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
        } catch (ValidationException $exception) {
            return $this->createResponseFromArray(
                $exception->getViolations(),
                422
            );
        } catch (DomainException $exception) {
            return $this->createTranslatedResponseFromArray(
                $exception->getViolations(),
                422
            );
        }

        return $this->createTranslatedResponseFromArray(['uuid' => $uuid], 201);
    }

    private function getDateTimeFrom($timestamp): \DateTime
    {
        return (new \DateTime())
            ->setTimestamp(
                $timestamp
            );
    }
}
