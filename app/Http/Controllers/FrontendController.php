<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Router\Resolver;

class FrontendController
{
    /**
     * Render the routed resource to the frontend.
     *
     * @param  \Illuminate\Http\Request $request
     * @return mixed
     */
    public function __invoke(Request $request)
    {
        $resolver = new Resolver($request);

        $resolver->resolveDomain();

        $resource = $resolver->resolveResource();

        return $resource->toResponse($request)->with(
            $this->prepareResponseData($resolver)
        );
    }

    protected function prepareResponseData(Resolver $resolver): array
    {
        $data = [];

        return $data;
    }
}
