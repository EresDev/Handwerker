<?php

namespace App\Service;

interface Uuid
{
    public function generate(): string;
}
