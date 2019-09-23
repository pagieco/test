<?php

namespace App\Http\Controllers\Api\Email;

use App\Models\Email;
use App\Http\Response;
use App\Http\Controllers\Controller;

class DeleteEmailController extends Controller
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
     * Delete the given email.
     *
     * @param  \App\Models\Email $email
     * @return void
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function __invoke(Email $email): void
    {
        $this->authorize('delete', $email);

        $email->delete();

        abort(Response::HTTP_NO_CONTENT);
    }
}
