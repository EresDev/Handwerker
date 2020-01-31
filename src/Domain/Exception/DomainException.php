<?php

declare(strict_types=1);

namespace App\Domain\Exception;

class DomainException extends BaseException
{
    /**
     * @var array<int, string>|array<string, string>
     */
    private array $messages;

    /**
     * @param array<int, string>|array<string, string> $messages
     */
    private function __construct(array $messages)
    {
        $this->messages = $messages;
    }

    /**
     * @param array<int, string>|array<string, string> $messages
     */
    public static function fromMessages(array $messages): self
    {
        return new self($messages);
    }

    public function getMessages(): array
    {
        return $this->messages;
    }
}

