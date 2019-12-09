<?php

namespace App\Infrastructure\Persistence\Doctrine\Repository;

use App\Domain\Entity\Note;
use App\Domain\Entity\User;
use App\Domain\Repository\Note\NoteFinder;
use App\Domain\Repository\Note\NoteUpdater;
use App\Domain\Repository\Note\UpdateUserAndNoteUnitOfWorkExample;
use Doctrine\Common\Persistence\ObjectRepository;
use Doctrine\ORM\EntityManagerInterface;

class NoteRepositoryImpl implements NoteFinder, NoteUpdater, UpdateUserAndNoteUnitOfWorkExample
{
    private EntityManagerInterface $entityManager;
    private ObjectRepository $repository;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(Note::class);
    }

    public function find(int $id): Note
    {
        return $this->repository->find($id);
    }

    public function update(Note $note): void
    {
        $this->entityManager->persist($note);
        $this->save();
    }

    public function updateSpecialUseCase(Note $note, User $user): void
    {
        $this->entityManager->persist($note);
        $this->entityManager->persist($user);
        $this->save();
    }

    public function save(): void
    {
        $this->entityManager->flush();
    }
}
