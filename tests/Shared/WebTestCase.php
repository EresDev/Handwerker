<?php

declare(strict_types=1);

namespace App\Tests\Shared;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase as SymfonyWebTestCase;

class WebTestCase extends SymfonyWebTestCase
{
    protected function getService(string $className): object
    {
        return self::$container->get($className);
    }
}
