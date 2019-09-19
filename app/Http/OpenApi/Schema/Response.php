<?php

namespace App\Http\OpenApi\Schema;

use cebe\openapi\spec\Operation;
use Illuminate\Http\Response as HttpResponse;
use Illuminate\Foundation\Testing\TestResponse;

class Response
{
    /**
     * The test response instance.
     *
     * @var \Illuminate\Foundation\Testing\TestResponse
     */
    protected $response;

    /**
     * The spec operation instance.
     *
     * @var \cebe\openapi\spec\Operation
     */
    protected $operation;

    /**
     * Create a new response instance.
     *
     * @param  \Illuminate\Foundation\Testing\TestResponse $response
     * @return void
     */
    public function __construct(TestResponse $response)
    {
        $this->response = $response;
    }

    /**
     * @param  \cebe\openapi\spec\Operation $operation
     * @return void
     */
    public function setOperation(Operation $operation): void
    {
        $this->operation = $operation;
    }

    public function isNoContentResponse(): bool
    {
        return $this->getStatusCode() === HttpResponse::HTTP_NO_CONTENT
            && isset($this->operation->responses[HttpResponse::HTTP_NO_CONTENT])
            && empty($this->getContent());
    }

    /**
     * Dynamically proxy property calls to the underlying response object.
     *
     * @param  string $key
     * @return mixed
     */
    public function __get(string $key)
    {
        return $this->response->{$key};
    }

    /**
     * Dynamically proxy method calls to the underlying response.
     *
     * @param  string $name
     * @param  array $arguments
     * @return mixed
     */
    public function __call(string $name, array $arguments)
    {
        return $this->response->{$name}(...$arguments);
    }
}
