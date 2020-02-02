<?php

declare(strict_types=1);

namespace App\Infrastructure\Service\Http;

use JsonSerializable;

class ErrorResponseContent implements JsonSerializable
{
    protected string $status;
    protected string $message;

    public function __construct(string $message)
    {
        $this->message = $message;
        $this->status = 'error';
    }

    public function jsonSerialize(): array
    {
        return [
            'status' => $this->status,
            'message' => $this->message,
        ];
    }

    public function hasValidFormat(string $content): bool
    {
        $contentArray = json_decode($content, true);

        return isset($contentArray['status']) &&
            $contentArray['status'] == $this->status &&
            isset($contentArray['message']);
    }
}
