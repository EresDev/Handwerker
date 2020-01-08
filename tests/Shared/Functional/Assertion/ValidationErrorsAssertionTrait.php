<?php

declare(strict_types=1);

namespace App\Tests\Shared\Functional\Assertion;

use PHPUnit\Framework\Assert;
use Symfony\Component\HttpFoundation\Response;

trait ValidationErrorsAssertionTrait
{
    protected function assertForValidationError(
        Response $response,
        array $expectedContent,
        string $invalidField
    ): void {
        $response = $this->response();
        Assert::assertEquals(422, $response->getStatusCode());

        Assert::assertEquals(
            json_encode($expectedContent),
            $response->getContent(),
            sprintf("Validation error received for invalid %s is not as expected.", $invalidField)
        );
    }
}
