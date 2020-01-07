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
        $contentObject = json_decode($content);

        $this->assertObjectHasAttribute(
            $invalidField,
            $contentObject,
            sprintf(
                "Validation errors does not contain error for invalid %s. " .
                "Errors received are: \n%s",
                $invalidField,
                print_r($contentObject, true)
            )
        );

        $this->assertEquals(
            $expectedError,
            $contentObject->$invalidField,
            sprintf("Validation error received for invalid %s is not as expected.", $invalidField)
        );
    }
}
