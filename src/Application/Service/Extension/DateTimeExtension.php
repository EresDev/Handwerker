<?php

declare(strict_types=1);

namespace App\Application\Service\Extension;

use DateTime;

class DateTimeExtension extends DateTime
{
    public static function from(int $timestamp): self
    {
        return (new self())
            ->setTimestamp(
                $timestamp
            );
    }
}
