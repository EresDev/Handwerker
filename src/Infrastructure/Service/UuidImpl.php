<?php

namespace App\Infrastructure\Service;

use App\Service\Uuid;
use Ramsey\Uuid\Uuid as RamseyUuid;

class UuidImpl implements Uuid
{
    public function generate(): string
    {
        return RamseyUuid::uuid4()->toString();
    }
}
