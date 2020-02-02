<?php

declare(strict_types=1);

namespace App\Infrastructure\Service\Http;

abstract class Status
{
    public const SUCCESS = 'success';
    public const FAIL = 'fail';
    public const ERROR = 'error';
}
