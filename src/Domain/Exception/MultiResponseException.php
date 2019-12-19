<?php

declare(strict_types=1);

namespace App\Domain\Exception;

abstract class MultiResponseException extends \Exception
{
    abstract public function getMessagesForEndUser(): array;
}
