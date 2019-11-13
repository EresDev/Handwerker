<?php

namespace App\Tests;

use Hautelook\AliceBundle\PhpUnit\RefreshDatabaseTrait;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserFixtureTest extends WebTestCase
{
    use RefreshDatabaseTrait;

    public function testUserFixture() : void
    {
        $client = static::createClient(); // The transaction starts just after the boot of the Symfony kernel

        return;
    }
}
