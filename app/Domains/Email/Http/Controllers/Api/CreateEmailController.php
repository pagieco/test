<?php

namespace App\Domains\Email\Http\Controllers\Api;

use App\Domains\Email\Models\Email;
use App\Http\Controllers\Controller;
use App\Domains\Email\Http\Resources\EmailResource;
use App\Domains\Email\Http\Requests\CreateEmailRequest;

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
     * @param  \App\Domains\Email\Http\Requests\CreateEmailRequest $request
     * @return \App\Domains\Email\Http\Resources\EmailResource
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
