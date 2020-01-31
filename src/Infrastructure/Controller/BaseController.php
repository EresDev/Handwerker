<?php

declare(strict_types=1);

namespace App\Infrastructure\Controller;

use App\Application\Service\Translator;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

abstract class BaseController
{
    private Translator $translator;
    protected Request $request;

    public function __construct(Translator $translator, RequestStack $requestStack)
    {
        $this->translator = $translator;
        $this->request = $requestStack->getCurrentRequest();
    }

    protected function createEmptyResponse(int $httpStatusCode): JsonResponse
    {
        return new JsonResponse(
            [],
            $httpStatusCode
        );
    }

    protected function createTranslatedResponseFromArray(
        array $content,
        int $httpStatusCode
    ): JsonResponse {
        $translatedContent = $this->translator->translateValues($content);
        return $this->createResponseFromArray($translatedContent, $httpStatusCode);
    }

    protected function createResponseFromArray(
        array $content,
        int $httpStatusCode
    ): JsonResponse {
        return new JsonResponse($content, $httpStatusCode);
    }
}
