<?php

namespace App\Domains\Domain\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Domains\Domain\Models\Domain;
use App\Domains\Domain\Http\Resources\DomainResource;
use App\Domains\Domain\Http\Requests\CreateDomainRequest;

class CreateDomainController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Create a new domain from the given request.
     *
     * @param  \App\Domains\Domain\Http\Requests\CreateDomainRequest $request
     * @return \App\Domains\Domain\Http\Resources\DomainResource
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function __invoke(CreateDomainRequest $request): DomainResource
    {
        $this->authorize('create', Domain::class);

        $domain = $request->user()->currentProject()
            ->domains()
            ->create($request->all());

        return new DomainResource($domain);
    }
}
