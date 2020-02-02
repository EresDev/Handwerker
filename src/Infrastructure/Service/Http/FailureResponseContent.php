<?php

declare(strict_types=1);

namespace App\Infrastructure\Service\Http;

class FailureResponseContent extends ResponseContent
{
    public function __construct(array $data)
    {
        parent::__construct($data);
        $this->status = 'fail';
    }
}
