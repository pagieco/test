<?php

namespace App\Http\Router;

use App\Models\Domain;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Router\Resolvers\PageResolver;
use App\Http\Router\Resolvers\DomainResolver;
use Illuminate\Contracts\Support\Responsable;

class Resolver
{
    protected $resolvers = [
        PageResolver::class,
    ];

    protected $request;

    protected $domain;

    /**
     * Create a new resolver instance.
     *
     * @param  \Illuminate\Http\Request $request
     * @return void
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Resolve for the current domain.
     *
     * @return \App\Models\Domain|null
     */
    public function resolveDomain(): ?Domain
    {
        $domain = DomainResolver::resolve($this->request);

        return $this->domain = $domain;
    }

    /**
     * Resolve for the current resource.
     *
     * @return \Illuminate\Contracts\Support\Responsable|null
     */
    public function resolveResource(): ?Responsable
    {
        $resource = $this->resolves($this->request);

        return $this->resource = $resource;
    }

    /**
     * Determine that the current request matches one of the resources.
     * When nothing matches, a 404 response will be thrown. Otherwise
     * the matched record will be returned for further dispatching.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Contracts\Support\Responsable|null
     */
    protected function resolves($request): ?Responsable
    {
        foreach ($this->resolvers as $resource => $resolver) {
            if (null === ($match = $resolver::resolve($request, $this->domain))) {
                continue;
            }

            return $match;
        }

        abort(Response::HTTP_NOT_FOUND);
    }
}
