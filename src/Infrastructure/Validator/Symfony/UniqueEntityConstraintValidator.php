<?php

declare(strict_types=1);

namespace App\Infrastructure\Validator\Symfony;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\ConstraintDefinitionException;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

class UniqueEntityConstraintValidator extends ConstraintValidator
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function validate($value, Constraint $constraint)
    {
        if (!$constraint instanceof UniqueEntityConstraint) {
            throw new UnexpectedTypeException($constraint, UniqueEntityConstraint::class);
        }

        // custom constraints should ignore null and empty values to allow
        // other constraints (NotBlank, NotNull, etc.) take care of that
        if (null === $value || '' === $value) {
            return;
        }

        $repository = $this->entityManager->getRepository($constraint->entityClass);

        if (!$repository) {
            throw new ConstraintDefinitionException(sprintf('Unable to find the repository associated with an entity of class "%s".', $constraint->entityClass));
        }

        $fields = (array) $constraint->fields;

        foreach ($fields as $fieldName) {

            $method = 'get'.ucwords($fieldName);

            if(! method_exists($constraint->entityClass, $method) ) {
                throw new ConstraintDefinitionException(sprintf('The entity "%s" does not have method %s.', $constraint->entityClass, $fieldName));
            }

            if(! method_exists(get_class($value),$method) ) {
                throw new ConstraintDefinitionException(sprintf('"%s" does not have method %s.', get_class($value), $method));
            }

            $result = $repository->findOneBy([$fieldName => $value->$method()]);
            if($result){
                $this->context->buildViolation($constraint->message)
                    ->atPath($fieldName)
                    ->setParameter('{{ string }}', $value)
                    ->addViolation();
            }
        }
    }
}
