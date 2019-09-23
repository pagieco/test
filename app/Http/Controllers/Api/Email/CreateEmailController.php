<?php

namespace App\Http\Controllers\Api\Email;

use App\Models\Email;
use App\Http\Controllers\Controller;
use App\Http\Resources\EmailResource;
use App\Http\Requests\CreateEmailRequest;

class CreateEmailController extends Controller
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
     * Create a new email from the request.
     *
     * @param  \App\Http\Requests\CreateEmailRequest $request
     * @return \App\Http\Resources\EmailResource
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function __invoke(CreateEmailRequest $request): EmailResource
    {
        $this->authorize('create', Email::class);

        $email = $request->user()
            ->currentProject()
            ->emails()
            ->create($request->all());

        return new EmailResource($email);
    }
}
