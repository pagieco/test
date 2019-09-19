<?php

namespace App\Http\Controllers\Api\Email;

use App\Models\Email;
use App\Http\Controllers\Controller;
use App\Http\Resources\EmailResource;

class GetEmailController extends Controller
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
     * Show the given email.
     *
     * @param  \App\Models\Email $email
     * @return \App\Http\Resources\EmailResource
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function __invoke(Email $email): EmailResource
    {
        $this->authorize('view', $email);

        return new EmailResource($email);
    }
}
