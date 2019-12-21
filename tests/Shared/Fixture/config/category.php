<?php

declare(strict_types=1);

use App\Domain\Entity\Category;
use App\Tests\Shared\Fixture\CategoryFixture;

return [
    Category::class => [
        'category_1' => [
            '__construct' => [
                CategoryFixture::UUID,
                CategoryFixture::TITLE,
                CategoryFixture::IMAGE_URI
            ]
        ],
    ],
];
