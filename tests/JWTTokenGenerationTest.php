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
//         * @var $encoder \App\ThirdParty\Security\Symfony\PasswordEncoder
//         */
//        $encoder = self::$container->get(PasswordEncoder::class);
//        $plainPassword = 'somePassword1145236';
//
//        $user = new User(6, 'auth_user6@eresdev.com', ['USER']);
//        $encoded = $encoder->encodePassword($plainPassword, '');
//
//        $user->setPassword($encoded);
//        $urole = new UserRole();
//        $urole->setUser($user);
//        $role = new Role();
//        $role->setId(1);
//        $urole->setRole($role);
//        $user->setRoles([$urole]);
//
//        /**
//         * @var $em EntityManagerInterface
//         */
//        $em = self::$container->get(EntityManagerInterface::class);
//        $em->persist($user);
//        $em->flush();
//
//    }
}
