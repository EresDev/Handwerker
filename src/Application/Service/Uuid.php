<?php

namespace App\Application\Service;

interface Uuid
{
    public function generate(): string;
}
