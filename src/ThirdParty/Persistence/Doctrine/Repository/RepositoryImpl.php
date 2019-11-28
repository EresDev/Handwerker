<?php

namespace App\ThirdParty\Persistence\Doctrine\Repository;

use App\Domain\Entity\Entity;
use App\Domain\Repository\Repository;
use Doctrine\ORM\EntityManagerInterface;


class RepositoryImpl implements Repository
{
    protected $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function get(int $entityId, string $entityCLass) : ?Entity
    {
        return $this->getBy('id', $entityId, $entityCLass);
    }

    public function getBy(string $key, $value, string $entityCLass) : ?Entity
    {
        return $this->entityManager
            ->getRepository($entityCLass)
            ->findOneBy([$key => $value]);
    }

//    public function getAll() : array
//    {
//        return $this->entityManager
//            ->getRepository($this->getEntityClass())
//            ->findAll();
//    }

    public function save(Entity $entity): void
    {
        $this->entityManager->persist($entity);
        $this->entityManager->flush();
    }

    public function delete(Entity $entity): void
    {
        $this->entityManager->remove($entity);
        $this->entityManager->flush();
    }

//    public function update(Entity $entity): void
//    {
//        $this->entityManager->merge($entity);
//        $this->entityManager->flush();
//    }
}
