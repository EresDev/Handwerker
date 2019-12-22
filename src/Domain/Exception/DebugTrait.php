<?php

declare(strict_types=1);

namespace App\Domain\Exception;

trait DebugTrait
{
    private string $debugInfo;

    public function withDebugInfo(string $info): self
    {
        $this->debugInfo = $info;
        return $this;
    }
}
