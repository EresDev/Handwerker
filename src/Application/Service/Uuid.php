<?php

declare(strict_types=1);

namespace App\Application\Service;

interface Uuid
{
    public function generate(): string;
}
