<?php

declare(strict_types=1);

namespace App\Tests\Shared\Functional\Assertion;

use Symfony\Component\HttpFoundation\Response;

trait Assertion404NotFoundTrait
{
    public function assertForValidButNonExistingEntityUuid(
        array $expectedContent,
        Response $response
    ): void {
        $this->assertEquals(
            404,
            $response->getStatusCode()
        );

        $this->assertEquals(
            json_encode($expectedContent),
            $response->getContent(),
            sprintf("Validation error received for valid but non existing %s is not as expected.", 'uuid')
        );
    }
}
