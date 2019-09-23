<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Requests\UploadProfilePictureRequest;

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

    public function __invoke(UploadProfilePictureRequest $request)
    {
        $user = $request->user();

        $user->update([
            'picture' => $user->uploadprofilepicture($request->file('picture')),
        ]);

        return Response::created();
    }
}
