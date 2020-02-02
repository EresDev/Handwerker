<?php

declare(strict_types=1);

namespace App\Tests\Shared\Functional\Assertion;

use PHPUnit\Framework\Assert;
use Symfony\Component\HttpFoundation\Response;

trait ValidationErrorsAssertionTrait
{
    protected function assertForValidationError(
        Response $response,
        array $expectedErrors,
        string $invalidField
    ): void {
        $response = $this->response();
        Assert::assertEquals(422, $response->getStatusCode());

        Assert::assertEquals(
            json_encode(['status' => 'fail', 'data' => $expectedErrors]),
            $response->getContent(),
            sprintf("Validation error received for invalid %s is not as expected.", $invalidField)
        );
    }
}
