<?php

namespace App\Macros;

use Closure;
use App\Http\OpenApi\Schema\TestValidator as SchemaValidator;

class TestResposeMixin
{
    /**
     * Assert that the given open-api schema equals the request.
     *
     * @return \Closure
     */
    public function assertSchema(): Closure
    {
        return function (string $operationId, int $statusCode): void {
            $validator = new SchemaValidator($this);

            $validator->assertSchema($operationId, $statusCode);
        };
    }
}
