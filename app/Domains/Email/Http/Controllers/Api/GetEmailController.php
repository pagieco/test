<?php

namespace App\Domains\Email\Http\Controllers\Api;

use App\Domains\Email\Models\Email;
use App\Http\Controllers\Controller;
use App\Domains\Email\Http\Resources\EmailResource;

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
     * @param  \App\Domains\Email\Models\Email $email
     * @return \App\Domains\Email\Http\Resources\EmailResource
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function __invoke(Email $email): EmailResource
    {
        $this->authorize('view', $email);

        return new EmailResource($email);
    }
}
