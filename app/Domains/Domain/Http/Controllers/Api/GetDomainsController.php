<?php

namespace App\Domains\Domain\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Domains\Domain\Models\Domain;
use App\Domains\Domain\Http\Resources\DomainsResource;

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
     * @return \App\Domains\Domain\Http\Resources\DomainsResource
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
