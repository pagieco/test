<?php

namespace App\Domains\Domain\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Domains\Domain\Models\Domain;
use App\Domains\Domain\Http\Resources\DomainResource;

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
     * @param  \App\Domains\Domain\Models\Domain $domain
     * @return \App\Domains\Domain\Http\Resources\DomainResource
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function __invoke(Domain $domain): DomainResource
    {
        $this->authorize('view', $domain);

        return new DomainResource($domain);
    }
}
