<?php

declare(strict_types=1);

namespace App\Infrastructure\Controller;

use App\Application\Query\GetJobQuery;
use App\Application\QueryHandler\GetJobHandler;
use App\Application\Service\Security\Security;
use App\Application\Service\Translator;
use App\Domain\Entity\User;
use App\Infrastructure\Service\Http\ErrorResponseContent;
use App\Infrastructure\Service\Http\SuccessResponseContent;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

class GetJobController
{
    private Request $request;
    private Translator $translator;
    private User $user;
    private GetJobHandler $handler;

    public function __construct(
        RequestStack $requestStack,
        Translator $translator,
        Security $security,
        GetJobHandler $handler
    ) {
        $this->request = $requestStack->getCurrentRequest();
        $this->translator = $translator;
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

        if (is_null($job)) {
            return JsonResponse::create(
                new ErrorResponseContent(null),
                404
            );
        }

        return JsonResponse::create(
            new SuccessResponseContent($job->toArray()),
            200
        );
    }
}
