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
            'categoryId' => 804040
        ];
    }
}
