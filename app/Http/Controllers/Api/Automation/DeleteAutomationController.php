<?php

namespace App\Http\Controllers\Api\Automation;

use App\Http\Response;
use App\Models\Automation;
use App\Http\Controllers\Controller;

class DeleteAutomationController extends Controller
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
     * Delete the given automation.
     *
     * @param  \App\Models\Automation $automation
     * @return void
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function __invoke(Automation $automation): void
    {
        $this->authorize('delete', $automation);

        $automation->delete();

        abort(Response::HTTP_NO_CONTENT);
    }
}
