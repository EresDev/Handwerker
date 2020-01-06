<?php

declare(strict_types=1);

namespace App\Application\Service;

interface Translator
{
    public function translate(string $text): string;

    public function translateValues(array $array): array;
}
