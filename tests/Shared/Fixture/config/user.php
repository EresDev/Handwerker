<?php

declare(strict_types=1);

use App\Domain\Entity\User;
use App\Domain\ValueObject\Uuid;
use App\Tests\Shared\Fixture\UserFixture;

return [
    User::class => [
        'user_1' => [
            '__construct' => [
                Uuid::createFrom(UserFixture::UUID),
                UserFixture::EMAIL,
                '<encode(' . UserFixture::PLAIN_PASSWORD . ')>',
                [UserFixture::ROLE]
            ]
        ],
    ],
];
