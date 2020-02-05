<?php

declare(strict_types=1);

use App\Domain\Entity\Category;
use App\Domain\ValueObject\Uuid;
use App\Tests\Shared\Fixture\CategoryFixture;

return [
    Category::class => [
        'category_1' => [
            '__construct' => [
                Uuid::createFrom(CategoryFixture::UUID),
                CategoryFixture::TITLE,
                CategoryFixture::IMAGE_URI
            ]
        ],
    ],
];
