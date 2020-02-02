<?php

declare(strict_types=1);

namespace App\Infrastructure\Service\Http;

class ResponseContent implements \JsonSerializable
{
    private string $status;
    /**
     * @var array<string, string>
     */
    private array $data;

    public function __construct(string $status, array $data)
    {
        $this->status = $status;
        $this->data = $data;
    }

    public function jsonSerialize(): array
    {
        return [
            'status' => $this->status,
            'data' => $this->data,
        ];
    }

    public function hasEqualFields(string $content): bool
    {
        $contentArray = json_decode($content, true);

        return isset($contentArray['status']) &&
            $contentArray['status'] == $this->status &&
            isset($contentArray['data']);
    }
}
