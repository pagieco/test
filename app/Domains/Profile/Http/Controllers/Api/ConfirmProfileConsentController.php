<?php

namespace App\Domains\Profile\Http\Controllers\Api;

use App\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Domains\Profile\Models\Profile;

class ConfirmProfileConsentController extends Controller
{
    /**
     * Confirm consent of the given profile.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Domains\Profile\Models\Profile $profile
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke(Request $request, Profile $profile): JsonResponse
    {
        // Abort the request when the given signature in the request is invalid or there is no signature at all.
        abort_if(! $request->hasValidSignature(), Response::HTTP_NOT_ACCEPTABLE);

        // Abort the request when the user has already registered.
        abort_if($profile->has_consented, Response::HTTP_ALREADY_REPORTED);

        $profile->giveConsent();

        return Response::ok();
    }
}
