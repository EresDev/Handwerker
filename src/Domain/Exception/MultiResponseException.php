<?php

namespace App\Domain\Exception;

abstract class MultiResponseException extends \Exception
{
    abstract public function getMessagesForEndUser() : array;
}
