<?php

namespace App\Http\Controllers\Api\Domain;

use App\Models\Domain;
use App\Http\Controllers\Controller;
use App\Http\Resources\DomainResource;

class GetDomainController extends Controller
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
     * Show the given domain.
     *
     * @param  \App\Models\Domain $domain
     * @return \App\Http\Resources\DomainResource
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function __invoke(Domain $domain): DomainResource
    {
        $this->authorize('view', $domain);

        return new DomainResource($domain);
    }
}
