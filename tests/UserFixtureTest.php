<?php

namespace App\Tests;

use App\Domain\Entity\User;
use App\ThirdParty\Security\Symfony\PasswordEncoderAdapter;
use Doctrine\ORM\EntityManagerInterface;
use Hautelook\AliceBundle\PhpUnit\RefreshDatabaseTrait;
use Nelmio\Alice\Loader\NativeLoader;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserFixtureTest extends KernelTestCase
{
    use RefreshDatabaseTrait;

    protected $fixture;

    protected function setUp(): void
    {
        self::bootKernel();
        $loader = new NativeLoader();
        $loader->getFakerGenerator()->addProvider(
            self::$container->get(PasswordEncoderAdapter::class)
        );
        $this->fixture = $loader->loadFile(__DIR__ . '/../fixtures/user.yaml');
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
            ->find($user->getId());

        $this->assertTrue($user->equals($userFromDb));
    }
}
