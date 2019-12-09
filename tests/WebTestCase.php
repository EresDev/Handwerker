<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase as SymfonyWebTestCase;
use Symfony\Component\BrowserKit\Request;
use Symfony\Component\HttpFoundation\Response;

class WebTestCase extends SymfonyWebTestCase
{
    protected KernelBrowser $client;
    private Request $request;

    protected function setUp(): void
    {
        parent::setUp();
        $this->client = static::createClient();
    }

    protected function sendRequest(array $parameters): void
    {
        $this->client->request(
            'post',
            '/user',
            $parameters,
            [],
            []
        );
    }

    protected function response(): Response
    {
        return $this->client->getResponse();
    }

    protected function request(
        string $method,
        string $uri,
        array $parameters=[],
        array $files=[],
        array $server=[],
        string $content=null,
        bool $changeHistory=true
    ) : void {
        $this->client->request(
            $method,
            $uri,
            $parameters,
            $files,
            $server,
            $content,
            $changeHistory
        );
    }
}
