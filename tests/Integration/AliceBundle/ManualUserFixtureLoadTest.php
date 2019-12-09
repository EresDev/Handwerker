<?php

namespace App\Tests\Integration\AliceBundle;

use App\Domain\Entity\User;
use App\Infrastructure\Security\Symfony\PasswordEncoderAdapter;
use Doctrine\ORM\EntityManagerInterface;
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
        $this->fixture = $loader->loadFile(self::$kernel->getProjectDir().'/fixtures/user.yaml');
    }

    public function testUserFixture() : void
    {
        /**
         * @var EntityManagerInterface $entityManager
         */
        $entityManager = self::$container->get(EntityManagerInterface::class);

        /**
         * @var User $user
         */
        $user = $this->fixture->getObjects()['user_1'];

        /**
         * @var User $user
         */
        $userFromDb = $entityManager
            ->getRepository(User::class)
            ->findOneBy(['uuid' => $user->getUuid()]);

        $this->assertNotNull($userFromDb);
        $this->assertEquals($user->getUuid(), $userFromDb->getUuid());
    }
}
