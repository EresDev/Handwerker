<?php

namespace App\Infrastructure\Service;

use App\Application\Service\Uuid;
use Ramsey\Uuid\Uuid as RamseyUuid;

class UuidAdapter implements Uuid
{
    public function generate(): string
    {
        return RamseyUuid::uuid4()->toString();
    }
}
