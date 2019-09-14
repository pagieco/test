<?php

namespace App\Http\OpenApi\Schema;

use cebe\openapi\Reader;
use Illuminate\Support\Str;
use Illuminate\Http\Response;
use cebe\openapi\spec\Schema;
use cebe\openapi\spec\OpenApi;
use cebe\openapi\spec\Operation;
use cebe\openapi\SpecObjectInterface;
use PHPUnit\Framework\TestCase as PHPUnit;
use Illuminate\Foundation\Testing\TestResponse;

class TestValidator
{
    /**
     * @var \Illuminate\Foundation\Testing\TestResponse
     */
    protected $response;

    /**
     * Create a new openapi validator instance.
     *
     * @param  \Illuminate\Foundation\Testing\TestResponse $response
     * @return void
     */
    public function __construct(TestResponse $response)
    {
        $this->response = $response;
    }

    /**
     * Assert that the schema matches the given operation.
     *
     * @param  string $operationId
     * @param  int $statusCode
     * @param  array $override
     * @throws \cebe\openapi\exceptions\TypeErrorException
     * @throws \cebe\openapi\exceptions\UnresolvableReferenceException
     */
    public function assertSchema(string $operationId, int $statusCode = 200, array $override = null): void
    {
        $response = $this->response;

        $operation = $this->getOperation(
            $response,
            $this->openSchemaFile(),
            $operationId
        );

        if ($statusCode === Response::HTTP_NO_CONTENT
            && isset($operation->responses[Response::HTTP_NO_CONTENT])
            && empty($response->getContent())) {
            $response->assertStatus($statusCode);

            return;
        }

        $schema = $this->transformSchema(
            $this->getSchema($operation, $statusCode)
        );

        if ($override) {
            $schema = array_merge($schema, $override);
        }

        $response->assertStatus($statusCode);
        $response->assertJsonStructure($schema);
    }

    /**
     * @return \cebe\openapi\spec\OpenApi|\cebe\openapi\SpecObjectInterface
     * @throws \cebe\openapi\exceptions\TypeErrorException
     * @throws \cebe\openapi\exceptions\UnresolvableReferenceException
     */
    protected function openSchemaFile(): SpecObjectInterface
    {
        return Reader::readFromYamlFile(base_path('open-api.yml'));
    }

    /**
     * Get the operation from the spec.
     *
     * @param  \Illuminate\Foundation\Testing\TestResponse $response
     * @param  \cebe\openapi\spec\OpenApi $spec
     * @param  string $operationId
     * @return \cebe\openapi\spec\Operation|null
     */
    protected function getOperation(TestResponse $response, OpenApi $spec, string $operationId): Operation
    {
        $specOperation = null;

        $requestPath = str_replace('api', '', $response->baseResponse->headers->get('x-origin-path'));

        foreach ($spec->paths as $path => $definition) {
            foreach ($definition->getOperations() as $method => $operation) {
                if ($operation->operationId === $operationId) {
                    $this->validatePaths($requestPath, $path);

                    $specOperation = $operation;
                }
            }
        }

        if ($specOperation === null) {
            PHPUnit::fail('Spec operation not found.');
        }

        return $specOperation;
    }

    /**
     * Get the schema by the given operation and statusCode.
     *
     * @param  \cebe\openapi\spec\Operation $operation
     * @param  int $statusCode
     * @return \cebe\openapi\spec\Schema
     */
    protected function getSchema(Operation $operation, int $statusCode): Schema
    {
        $response = $operation->responses[$statusCode];

        if (! isset($response)) {
            PHPUnit::fail("Schema with statusCode {$statusCode} not found.");
        }

        if (! isset($response->content['application/json'])) {
            PHPUnit::fail('Response "application/json" not found.');
        }

        return $response->content['application/json']->schema;
    }

    /**
     * Transform the given schema into an array.
     *
     * @param  \cebe\openapi\spec\Schema|array $schema
     * @return array
     */
    protected function transformSchema($schema): array
    {
        $output = [];

        if (isset($schema->properties)) {
            foreach ($schema->properties as $key => $attributes) {
                switch ($attributes->type) {
                    case null:
                    case 'object':
                        $output[$key] = $this->transformSchema($attributes->properties);
                        break;

                    case 'array':
                        $output[$key] = [$this->transformSchema($attributes->items)];
                        break;

                    default:
                        array_push($output, $key);
                }
            }
        }

        foreach ($schema as $key => $value) {
            if ($value->properties) {
                $output[$key] = $this->transformSchema($value->properties);
            } else {
                array_push($output, $key);
            }
        }

        return $output;
    }

    /**
     * Validate the reuqest and schema paths.
     *
     * @param  string $requestPath
     * @param  string $schemaPath
     * @return void
     */
    protected function validatePaths(string $requestPath, string $schemaPath): void
    {
        $requestPathParts = array_values(array_filter(explode('/', $requestPath)));
        $schemaPathParts = array_values(array_filter(explode('/', $schemaPath)));

        foreach ($schemaPathParts as $key => $part) {
            if (Str::startsWith($part, '{') && Str::endsWith($part, '}')) {
                $schemaPathParts[$key] = $requestPathParts[$key];
            }
        }

        PHPUnit::assertEquals(
            implode('/', $requestPathParts),
            implode('/', $schemaPathParts)
        );
    }
}
