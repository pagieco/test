<?php

namespace App\Domains\Domain\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Domains\Domain\Models\Domain;
use App\Domains\Domain\Http\Resources\DomainResource;
use App\Domains\Domain\Http\Requests\UpdateDomainRequest;

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
     * @param  \App\Domains\Domain\Http\Requests\UpdateDomainRequest $request
     * @param  \App\Domains\Domain\Models\Domain $domain
     * @return \App\Domains\Domain\Http\Resources\DomainResource
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function __invoke(UpdateDomainRequest $request, Domain $domain)
    {
        $this->authorize('update', $domain);

        $domain->update($request->all());

        return new DomainResource($domain);
    }
}
