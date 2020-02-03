<?php

declare(strict_types=1);

namespace App\Tests\Integration\Infrastructure\Validator\Symfony;

use App\Domain\Exception\ValidationException;
use App\Infrastructure\Validator\Symfony\ValidatorAdapter;
use App\Tests\Integration\Infrastructure\Validator\TestCommand;
use App\Tests\Shared\KernelTestCase;
use Hautelook\AliceBundle\PhpUnit\RefreshDatabaseTrait;
use Symfony\Component\Validator\ContainerConstraintValidatorFactory;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ValidatorAdapterTest extends KernelTestCase
{
    use RefreshDatabaseTrait;
    private ValidatorInterface $validator;

    protected function setUp(): void
    {
        parent::setUp();
        self::bootKernel();

        $validatorBuilder = Validation::createValidatorBuilder();
        $validatorBuilder->setConstraintValidatorFactory(
            new ContainerConstraintValidatorFactory(self::$container)
        );

        $this->validator = $validatorBuilder
            ->addYamlMapping(__DIR__ . '/../validation.yaml')
            ->getValidator();
    }

    public function testValidateForUniqueEntityConstraintByTryingToAddUserWithExistingEmail(): void
    {
        $this->expectException(ValidationException::class);
        /**
         * @var User $user
         */
        $user = self::$fixtures['user_1'];

        $command = new TestCommand(
            'cc22a28c-19fa-11ea-978f-2e728ce88125',
            $user->getEmail()
        );

        $validatorAdapter = new ValidatorAdapter($this->validator);
        $validatorAdapter->validate($command);
    }
}
