<?php

declare(strict_types=1);

namespace App\Tests\Shared\Fixture;

use App\Domain\Entity\Category;
use App\Domain\Entity\Job;
use App\Domain\Entity\User;
use DateTime;

abstract class JobFixture
{
    public const UUID = 'ccae6db1-165f-43d9-ad91-48c40a4d1ea4';
    public const TITLE = 'Kellersanierung';
    public const ZIP_CODE = '21521';
    public const CITY = 'Hamburg';
    public const DESCRIPTION = 'Job descriptions from fixture.';
    public const CATEGORY_ID = CategoryFixture::UUID;
    public const USER = UserFixture::UUID;

    public static function getExecutionDateTime(): DateTime
    {
        $executionDateTime = new \DateTime();
        $executionDateTime->modify('+2 days');

        return $executionDateTime;
    }

    public static function getExecutionTimestamp(): int
    {
        return self::getExecutionTimestamp()->getTimestamp();
    }

    public static function getInstance(): Job
    {
        return new Job(
            self::UUID,
            self::TITLE,
            self::ZIP_CODE,
            self::CITY,
            self::DESCRIPTION,
            self::getExecutionDateTime(),
            self::getCategory(),
            self::getUser()
        );
    }

    public static function getUser(): User
    {
        return UserFixture::getInstance();
    }

    public static function getCategory(): Category
    {
        return CategoryFixture::getInstance();
    }
}
