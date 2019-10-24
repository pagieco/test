<?php

namespace App\Domains\Email\Http\Controllers\Api;

use App\Domains\Email\Models\Email;
use App\Http\Controllers\Controller;
use App\Domains\Email\Http\Resources\EmailResource;
use App\Domains\Email\Http\Requests\UpdateEmailRequest;

class UpdateEmailController extends Controller
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
     * Update the given email
     *
     * @param  \App\Domains\Email\Http\Requests\UpdateEmailRequest $request
     * @param  \App\Domains\Email\Models\Email $email
     * @return \App\Domains\Email\Http\Resources\EmailResource
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function __invoke(UpdateEmailRequest $request, Email $email): EmailResource
    {
        $this->authorize('update', $email);

        $email->update($request->only('name'));

        return new EmailResource($email);
    }
}
