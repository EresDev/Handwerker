<?php

declare(strict_types=1);

namespace App\Tests\Shared;

class TestData
{
    /**
     * @var string|array
     */
    private $input;
    private $expectedValue;
    private string $testFailureReason;

    public function __construct($input, $expectedValue, string $testFailureReason)
    {
        $this->input = $input;
        $this->expectedValue = $expectedValue;
        $this->testFailureReason = $testFailureReason;
    }

    public function getInput()
    {
        return $this->input;
    }

    public function getExpectedValue()
    {
        return $this->expectedValue;
    }

    public function getTestFailureReason(): string
    {
        return $this->testFailureReason;
    }
}
