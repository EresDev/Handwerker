<?php

namespace App\ThirdParty\Http;

use App\Domain\Service\Http\PostParameter;
use Symfony\Component\HttpFoundation\RequestStack;

class PostParameterImpl implements PostParameter
{
    private $request;

    public function __construct(RequestStack $requestStack)
    {
        $this->request = $requestStack->getCurrentRequest();
    }

    public function get(string $key, string $defaultValue = ''): string
    {
        return $this->request->get($key, $defaultValue);
    }

    public function getAll(): array
    {
        return $this->request->request->all();
    }
}
