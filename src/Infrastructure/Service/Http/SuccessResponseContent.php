<?php

declare(strict_types=1);

namespace App\Infrastructure\Service\Http;

class SuccessResponseContent extends ResponseContent
{
    public function __construct(?array $data)
    {
        parent::__construct($data);
        $this->status = 'success';
    }
}
