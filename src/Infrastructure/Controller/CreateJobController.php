<?php

declare(strict_types=1);

namespace App\Infrastructure\Controller;

use App\Application\Command\CreateJobCommand;
use App\Application\CommandHandler\CreateJobHandler;
use App\Application\Service\Security\Security;
use App\Application\Service\Uuid;
use App\Domain\Entity\User;
use App\Domain\Exception\ValidationException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

class CreateJobController
{
    private Request $request;
    private Uuid $uuidGenerator;
    private CreateJobHandler $handler;
    private User $user;

    public function __construct(
        RequestStack $requestStack,
        Uuid $uuidGenerator,
        CreateJobHandler $handler,
        Security $security
    ) {
        $this->request = $requestStack->getCurrentRequest();
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
            $this->user->getUuid()
        );

        //try {
        $this->handler->handle($command);
//        } catch (ValidationException $exception) {
//            return new JsonResponse($exception->getMessage(), 422);
//        }

        return new JsonResponse(['uuid' => $uuid], 201);
    }

    private function getDateTimeFrom($timestamp): \DateTime
    {
        return (new \DateTime())
            ->setTimestamp(
                $timestamp
            );
    }
}
