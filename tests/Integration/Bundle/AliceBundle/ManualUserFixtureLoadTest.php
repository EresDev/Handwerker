<?php

declare(strict_types=1);

namespace App\Tests\Integration\Bundle\AliceBundle;

use App\Domain\Entity\User;
use App\Domain\Repository\User\UserFinder;
use App\Infrastructure\Security\Symfony\PasswordEncoderAdapter;
use Nelmio\Alice\Loader\NativeLoader;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ManualUserFixtureLoadTest extends KernelTestCase
{
    protected $fixture;

    protected function setUp(): void
    {
        self::bootKernel();
        $loader = new NativeLoader();
        $loader->getFakerGenerator()->addProvider(
            self::$container->get(PasswordEncoderAdapter::class)
        );
        $this->fixture = $loader->loadFile(self::$kernel->getProjectDir() . '/fixtures/user.php');
    }

    public function testUserFixture() : void
    {
        /**
         * @var UserFinder $userFinder
         */
        $userFinder = self::$container->get(UserFinder::class);

        /**
         * @var User $user
         */
        $user = $this->fixture->getObjects()['user_1'];

        /**
         * @var User $user
         */
        $userFromDb = $userFinder->findOneBy('uuid', $user->getUuid());

        $this->assertNotNull($userFromDb);
        $this->assertEquals($user->getUuid(), $userFromDb->getUuid());
    }
}
