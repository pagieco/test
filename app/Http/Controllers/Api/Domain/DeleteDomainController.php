<?php

namespace App\Http\Controllers\Api\Domain;

use App\Models\Domain;
use App\Http\Response;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DeleteDomainController extends Controller
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
     * Delete the given domain.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Models\Domain $domain
     * @return void
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function __invoke(Request $request, Domain $domain): void
    {
        $this->authorize('delete', $domain);

        if ($request->user()->currentProject()->domains->count() === 1) {
            abort(Response::HTTP_BAD_REQUEST, 'You cannot delete your last domain.');
        }

        $domain->delete();

        abort(Response::HTTP_NO_CONTENT);
    }
}
