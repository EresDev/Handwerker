<?php

declare(strict_types=1);

namespace App\Infrastructure\Service\Http;

use JsonSerializable;

abstract class ResponseContent implements JsonSerializable
{
    protected string $status;
    /**
     * @var array<string, string>
     */
    protected ?array $data;

    public function __construct(?array $data)
    {
        $this->data = $data;
    }

    public function jsonSerialize(): array
    {
        return [
            'status' => $this->status,
            'data' => $this->data,
        ];
    }

    public static function hasValidFormat(string $content): bool
    {
        $contentArray = json_decode($content, true);

        return isset($contentArray['status']) &&
            in_array($contentArray['status'], ['success', 'fail']) &&
            isset($contentArray['data']);
    }
}
