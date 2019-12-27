<?php

declare(strict_types=1);

namespace App\Infrastructure\Controller;

use App\Application\Query\GetJobQuery;
use App\Application\QueryHandler\GetJobHandler;
use App\Application\Service\Security\Security;
use App\Domain\Entity\User;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

class GetJobController
{
    private Request $request;
    private User $user;
    private GetJobHandler $handler;

    public function __construct(RequestStack $requestStack, Security $security, GetJobHandler $handler)
    {
        $this->request = $requestStack->getCurrentRequest();
        $this->user = $security->getUser();
        $this->handler = $handler;
    }

    public function handleRequest(): JsonResponse
    {
        $query = new GetJobQuery(
            $this->request->get('uuid', ''),
            $this->user
        );

        $job = $this->handler->handle($query);

        if (!$job) {
            return new JsonResponse('', 404);
        }

        return new JsonResponse($job->toArray(), 200);
    }
}
