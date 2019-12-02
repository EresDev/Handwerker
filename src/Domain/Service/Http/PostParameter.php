<?php

namespace App\Domain\Service\Http;

interface PostParameter
{
    public function get(string $key, string $defaultValue = ''): string;
    public function getAll() : array;
}
