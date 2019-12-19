<?php

namespace App\Tests\Shared;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase as SymfonyKernelTestCase;

class KernelTestCase extends SymfonyKernelTestCase
{
    protected function getService(string $className): object
    {
        return self::$container->get($className);
    }
}
