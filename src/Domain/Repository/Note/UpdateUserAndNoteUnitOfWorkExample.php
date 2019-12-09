<?php

namespace App\Domain\Repository\Note;

use App\Domain\Entity\Note;
use App\Domain\Entity\User;

interface UpdateUserAndNoteUnitOfWorkExample
{
    public function updateSpecialUseCase(Note $note, User $user): void;
}
