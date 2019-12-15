<?php

namespace App\Tests\Shared\ObjectMother;

class JobMother
{
    public static function toValidParameterArray(bool $withTimestamp = true): array
    {
        $executionDateTime = new \DateTime();
        $executionDateTime->modify('+1 day');

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
