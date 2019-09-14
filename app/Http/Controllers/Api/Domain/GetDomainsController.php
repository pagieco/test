<?php

namespace App\Http\Controllers\Api\Domain;

use App\Models\Domain;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\DomainsResource;

class GetDomainsController extends Controller
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
     * Return a list of domains from the current project.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \App\Http\Resources\DomainsResource
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function __invoke(Request $request): DomainsResource
    {
        $this->authorize('list', Domain::class);

        $domains = $request->user()->currentProject()->domains;

        abort_if($domains->isEmpty(), Response::HTTP_NO_CONTENT);

        return new DomainsResource($domains);
    }
}
