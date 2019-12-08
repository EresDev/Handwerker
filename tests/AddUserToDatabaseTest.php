<?php

namespace App\Tests;


use App\Domain\Entity\User;
use App\Domain\Repository\DeleteRepository;
use App\Domain\Repository\SaveRepository;
use App\Domain\Repository\ReadRepository;
use App\Domain\Security\Role;
use Doctrine\ORM\EntityManagerInterface;
use Ramsey\Uuid\Uuid;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Security\Core\Encoder\NativePasswordEncoder;

class AddUserToDatabaseTest extends KernelTestCase
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

    /**
     * @var SaveRepository
     */
    private $saveRepository;

    /**
     * @var ReadRepository
     */
    private $readRepository;
    /**
     * @var DeleteRepository
     */
    private $deleteRespository;

    protected function setUp(): void
    {
        parent::setUp();
        self::bootKernel();

        $this->encoder = self::$container->get(NativePasswordEncoder::class);
        $this->entityManager = self::$container->get(EntityManagerInterface::class);
        $this->saveRepository = self::$container->get(SaveRepository::class);
        $this->readRepository = self::$container->get(ReadRepository::class);
        $this->deleteRespository = self::$container->get(DeleteRepository::class);

        $oldUser = $this->readRepository->getBy(
            'email',
            self::EMAIL,
            User::class
        );

        if ($oldUser) {
            $this->deleteRespository->delete($oldUser);
        }

    }

    public function testAddUser(): void
    {
        $user = new User();
        $user->setUuid(Uuid::uuid1());
        $user->setEmail(self::EMAIL);
        $encoded = $this->encoder->encodePassword(self::PASSWORD, $user->getSalt());

        $user->setPassword($encoded);

        $user->setRoles([Role::USER]);

        $this->assertNull($user->getId(), 'User ID is must be null before persist because' .
            ' ID is assigned by DB. But here ID is '. $user->getId() . ' for User ' .
            json_encode($user));

        $this->saveRepository->save($user);

        $this->assertNotNull($user->getId(), 'User was probably not persisted in database.' .
            json_encode($user));
    }

}
