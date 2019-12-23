<?php

declare(strict_types=1);

namespace App\Tests\Functional;

trait ValidationErrorsAssertionTrait
{
    //TODO: find the undefined methods solution
    protected function assertForValidationError(string $invalidField, string $expectedError): void
    {
        $response = $this->response();
        $this->assertEquals(422, $response->getStatusCode());

        $content = $response->getContent();
        $contentObjects = json_decode($content);

        $this->assertCount(
            1,
            $contentObjects,
            sprintf(
                "Number of received validation errors is not exactly one. The errors received are: %s\n",
                print_r($contentObjects, true)
            )
        );

        $this->assertObjectHasAttribute(
            $invalidField,
            $contentObjects[0],
            sprintf(
                "Validation errors does not contain error for invalid %s. " .
                "Errors received are: \n%s",
                $invalidField,
                print_r($contentObjects, true)
            )
        );

        $this->assertEquals(
            $expectedError,
            $contentObjects[0]->$invalidField,
            sprintf("Validation error received for invalid %s is not as expected.", $invalidField)
        );
    }
}
