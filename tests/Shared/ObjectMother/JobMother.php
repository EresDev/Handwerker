<?php

declare(strict_types=1);

namespace App\Tests\Shared\ObjectMother;

use App\Application\Service\Extension\DateTimeExtension;

class JobMother
{
    public static function toValidParameterArray(bool $withTimestamp = true): array
    {
        $executionDateTime = new DateTimeExtension();
        $executionDateTime->modify('+2 days');

        if ($withTimestamp) {
            $executionDateTime = $executionDateTime->getTimestamp();
        }

        return [
            'title' => 'A test title',
            'zipCode' => '06895',
            'city' => 'Bülzig',
            'description' => 'A test description',
            'executionDateTime' => $executionDateTime,
            'categoryId' => '0d195d63-cdc3-4286-90c9-0d6bb8e913ce'
        ];
    }
}
