<?php

namespace App\Domains\Email\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Domains\Email\Models\Email;
use App\Http\Controllers\Controller;
use App\Domains\Email\Http\Resources\EmailsResource;

class GetEmailsController extends Controller
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
     * Return a list of emails from the current project.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \App\Domains\Email\Http\Resources\EmailsResource
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function __invoke(Request $request): EmailsResource
    {
        $this->authorize('list', Email::class);

        $emails = $request->user()->currentProject()->emails;

        abort_if($emails->isEmpty(), Response::HTTP_NO_CONTENT);

        return new EmailsResource($emails);
    }
}
