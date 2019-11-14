<?php

namespace App\Tests;

use Hautelook\AliceBundle\PhpUnit\RefreshDatabaseTrait;
use Nelmio\Alice\Loader\NativeLoader;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserFixtureTest extends WebTestCase
{
    protected $fixture;

    use RefreshDatabaseTrait;

    protected function setUp(): void
    {
//        $loader = new NativeLoader();
//        $this->fixture = $loader->loadFile(__DIR__ . '/../fixtures/user.yaml');
    }

    public function testUserFixture() : void
    {
        $client = static::createClient(); // The transaction starts just after the boot of the Symfony kernel

        return;
    }
}
