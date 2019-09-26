<?php

namespace App\Http\Controllers\Api\Domain;

use App\Models\Domain;
use App\Http\Controllers\Controller;
use App\Http\Resources\DomainResource;
use App\Http\Requests\UpdateDomainRequest;

class UpdateDomainController extends Controller
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
     * Update the given domain.
     *
     * @param  \App\Http\Requests\UpdateDomainRequest $request
     * @param  \App\Models\Domain $domain
     * @return \App\Http\Resources\DomainResource
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function __invoke(UpdateDomainRequest $request, Domain $domain)
    {
        $this->authorize('update', $domain);

        $domain->update($request->all());

        return new DomainResource($domain);
    }
}
