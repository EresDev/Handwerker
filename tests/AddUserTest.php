<?php

namespace App\Tests;

use App\Domain\Entity\Role;
use App\Domain\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Security\Core\Encoder\NativePasswordEncoder;

class AddUserTest extends KernelTestCase
{
    private const EMAIL = 'user_from_addUser_test_willBeDeleted@eresdev.com';
    private const PASSWORD = 'foo_bar_password';
    /**
     * @var NativePasswordEncoder
     */
    private $encoder;

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    protected function setUp(): void
    {
        parent::setUp();
        self::bootKernel();

        $this->encoder = self::$container->get(NativePasswordEncoder::class);
        $this->entityManager = self::$container->get(EntityManagerInterface::class);

        $oldUser = $this->entityManager
            ->getRepository(User::class)
            ->findOneBy(['email' => self::EMAIL]);

        if ($oldUser) {
            $this->entityManager->remove($oldUser);
            $this->entityManager->flush();
        }

    }

    public function testAddUser(): void
    {
        $user = new User();

        $user->setEmail(self::EMAIL);
        $encoded = $this->encoder->encodePassword(self::PASSWORD, $user->getSalt());

        $user->setPassword($encoded);

        /**
         * TODO: The test needs a role existing in database. Setup Fixtures
         */
        $role = $this->entityManager->getRepository(Role::class)->findOneBy(['title' => 'USER']);
        $user->setRoles([$role]);

        $this->assertNull($user->getId(), 'User ID is must be null before persist because' .
            ' ID is assigned by DB. But here ID is '. $user->getId() . ' for User ' .
            json_encode($user));

//        $this->entityManager->persist($user);
//        $this->entityManager->flush();
//
//        $this->assertNotNull($user->getId(), 'User was probably not persisted in database.' .
//            json_encode($user));
    }

}
