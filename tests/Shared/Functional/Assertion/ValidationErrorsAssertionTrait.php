<?php

declare(strict_types=1);

namespace App\Tests\Shared\Functional\Assertion;

use PHPUnit\Framework\Assert;
use Symfony\Component\HttpFoundation\Response;

trait ValidationErrorsAssertionTrait
{
    protected function assertForError(
        Response $response,
        array $expectedContent,
        string $invalidField
    ): void {
        Assert::assertEquals(422, $response->getStatusCode());

        Assert::assertEquals(
            json_encode($expectedContent),
            $response->getContent(),
            sprintf("Error received for invalid %s is not as expected.", $invalidField)
        );
    }
}
