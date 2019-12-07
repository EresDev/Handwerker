<?php

namespace App\Domain\Exception;

abstract class BaseException extends \Exception
{
    abstract public function getMessageForEndUser() : string;
}
