<?php

declare(strict_types=1);

namespace App\Infrastructure\Controller;

use App\Application\Query\GetJobQuery;
use App\Application\QueryHandler\GetJobHandler;
use App\Application\Service\Security\Security;
use App\Application\Service\Translator;
use App\Domain\Entity\User;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RequestStack;

class GetJobController extends BaseController
{
    private User $user;
    private GetJobHandler $handler;

    public function __construct(
        Translator $translator,
        RequestStack $requestStack,
        Security $security,
        GetJobHandler $handler
    ) {
        parent::__construct($translator, $requestStack);

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
            return $this->createEmptyResponse(404);
        }

        return $this->createResponseFromArray($job->toArray(), 200);
    }
}
