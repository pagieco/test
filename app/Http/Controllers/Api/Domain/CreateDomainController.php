<?php

namespace App\Http\Controllers\Api\Domain;

use App\Models\Domain;
use App\Http\Controllers\Controller;
use App\Http\Resources\DomainResource;
use App\Http\Requests\CreateDomainRequest;

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
     * @param  \App\Http\Requests\CreateDomainRequest $request
     * @return \App\Http\Resources\DomainResource
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
