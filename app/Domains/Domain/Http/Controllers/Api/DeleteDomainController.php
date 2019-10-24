<?php

namespace App\Domains\Domain\Http\Controllers\Api;

use App\Http\Response;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Domains\Domain\Models\Domain;

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
     * @param  \App\Domains\Domain\Models\Domain $domain
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
