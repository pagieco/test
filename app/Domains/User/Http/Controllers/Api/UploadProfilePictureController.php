<?php

namespace App\Domains\User\Http\Controllers\Api;

use App\Http\Response;
use App\Http\Controllers\Controller;
use App\Domains\User\Http\Requests\UploadProfilePictureRequest;

class UploadProfilePictureController extends Controller
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
     * Upload a new profile picture.
     *
     * @param  \App\Domains\User\Http\Requests\UploadProfilePictureRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke(UploadProfilePictureRequest $request)
    {
        $request->user()->uploadprofilepicture($request->file('picture'));

        return Response::created();
    }
}
