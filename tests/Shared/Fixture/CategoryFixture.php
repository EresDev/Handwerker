<?php

declare(strict_types=1);

namespace App\Tests\Shared\Fixture;

use App\Domain\Entity\Category;
use App\Domain\ValueObject\Uuid;

abstract class CategoryFixture
{
    public const UUID = '0d195d63-cdc3-4286-90c9-0d6bb8e913ce';
    public const TITLE = 'Sonstige Umzugsleistungen';
    public const IMAGE_URI = 'image/uri';

    public static function getInstance(): Category
    {
        return new Category(
            Uuid::createFrom(self::UUID),
            self::TITLE,
            self::IMAGE_URI
        );
    }
}
