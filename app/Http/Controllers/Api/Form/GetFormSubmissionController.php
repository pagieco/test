<?php

namespace App\Http\Controllers\Api\Form;

use App\Http\Response;
use App\Models\FormSubmission;
use App\Http\Controllers\Controller;
use App\Http\Resources\FormSubmissionResource;

class GetFormSubmissionController extends Controller
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
     * Show the given form-submission.
     *
     * @param  \App\Models\FormSubmission $submission
     * @return \App\Http\Resources\FormSubmissionResource
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function __invoke(FormSubmission $submission): FormSubmissionResource
    {
        abort_if(is_null($submission->form), Response::HTTP_NOT_FOUND);

        $this->authorize('view-submission', $submission->form);

        return new FormSubmissionResource($submission);
    }
}
