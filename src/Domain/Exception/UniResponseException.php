<?php

namespace App\Domain\Exception;

abstract class UniResponseException extends \Exception
{
    abstract public function getMessageForEndUser() : string;
}
