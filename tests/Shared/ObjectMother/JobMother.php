<?php

namespace App\Tests\Shared\ObjectMother;

class JobMother
{
    public static function toValidParameterArray(): array
    {
        return [
            'title' => 'A test title',
            'zipCode' => '06895',
            'city' => 'Bülzig',
            'description' => 'A test description',
            'executionDateTime' => (new \DateTime())->modify('+1 day'),
            'categoryId' => '0d195d63-cdc3-4286-90c9-0d6bb8e913ce'
        ];
    }
}
