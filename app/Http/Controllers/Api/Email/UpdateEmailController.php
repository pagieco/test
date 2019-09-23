<?php

namespace App\Http\Controllers\Api\Email;

use App\Models\Email;
use App\Http\Controllers\Controller;
use App\Http\Resources\EmailResource;
use App\Http\Requests\UpdateEmailRequest;

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
     * @param  \App\Http\Requests\UpdateEmailRequest $request
     * @param  \App\Models\Email $email
     * @return \App\Http\Resources\EmailResource
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function __invoke(UpdateEmailRequest $request, Email $email): EmailResource
    {
        $this->authorize('update', $email);

        $email->update($request->only('name'));

        return new EmailResource($email);
    }
}
