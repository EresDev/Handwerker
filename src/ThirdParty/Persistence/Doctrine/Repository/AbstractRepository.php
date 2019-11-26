<?php

namespace App\ThirdParty\Persistence\Doctrine\Repository;

use App\Domain\Entity\Entity;
use App\Domain\Repository\Repository;
use Doctrine\ORM\EntityManagerInterface;


abstract class AbstractRepository implements Repository
{
    protected $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    abstract public function getEntityClass() : string;

    public function get(int $entityId) : ?Entity
    {
        return $this->getBy('id', $entityId);
    }

    public function getBy(string $key, $value) : ?Entity
    {
        return $this->entityManager
            ->getRepository($this->getEntityClass())
            ->findOneBy([$key => $value]);
    }

//    public function getAll() : array
//    {
//        return $this->entityManager
//            ->getRepository($this->getEntityClass())
//            ->findAll();
//    }

    public function save(Entity $entity) : void
    {
        $this->entityManager->persist($entity);
        $this->entityManager->flush();
    }

//    public function delete(int $entityId) : ?Entity
//    {
//        $entity = $this->getById($entityId);
//        if($entity != null){
//            $this->entityManager->remove($entity);
//            $this->entityManager->flush();
//        }
//        return $entity;
//    }
//    public function update(Entity $entity): void
//    {
//        $this->entityManager->merge($entity);
//        $this->entityManager->flush();
//    }
}
