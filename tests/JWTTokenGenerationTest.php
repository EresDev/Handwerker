<?php

namespace App\Tests;

use App\Domain\Entity\Role;
use App\Domain\Entity\User;
use App\Domain\Entity\UserRole;
use App\Kernel;
use App\ThirdParty\Security\Symfony\PasswordEncoder;
use App\ThirdParty\Security\Symfony\SecurityUser;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\TestCase;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\NativePasswordEncoder;
use Symfony\Component\Security\Core\Encoder\PasswordEncoderInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class JWTTokenGenerationTest extends WebTestCase
{
    private $request;

    protected function setUp() : void
    {
        parent::setUp();

        $this->request = Request::create(
            '/login_check',
            'POST',
            [],
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode(['email' => 'auth_user2@eresdev.com', 'password' => 'somePassword1145236'])
        );
    }

    public function testTokenGeneration() : void
    {
        //$this->addUser();
        $kernel = new Kernel('test', true);
        $response = $kernel->handle($this->request);
        //$this->addUser();
        //echo json_decode($response->getContent(), true)['message'];
        $this->assertArrayHasKey(
            'token',
            json_decode($response->getContent(), true)
        );
    }

//    private function addUser(): void
//    {
//        self::bootKernel();
//        /**
//         * @var $encoder NativePasswordEncoder
//         */
//        $encoder = self::$container->get(NativePasswordEncoder::class);
//        $plainPassword = 'somePassword1145236';
//
//        $user = new User();
//        $user->setEmail('user_from_addUser_test_willBeDeleted@eresdev.com');
//        $encoded = $encoder->encodePassword($plainPassword, '');
//
//        $user->setPassword($encoded);
//        /**
//         * @var $em EntityManagerInterface
//         */
//        $em = self::$container->get(EntityManagerInterface::class);
//
//        $role = $em->getRepository(Role::class)->find(1);
//        $user->setRoles([$role]);
//
//        $em->persist($user);
//        $em->flush();
//
//    }
}
