<?php

namespace App\Domain\Repository\Note;

use App\Domain\Entity\Note;

interface NoteUpdater
{
    public function update(Note $note): void;
}
