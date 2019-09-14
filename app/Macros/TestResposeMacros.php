<?php

namespace App\Macros;

use App\Http\OpenApi\Schema\TestValidator as SchemaValidator;

class TestResposeMacros
{
    public function assertSchema()
    {
        return function (string $operationId, int $statusCode) {
            $validator = new SchemaValidator($this);

            $validator->assertSchema($operationId, $statusCode);
        };
    }
}
