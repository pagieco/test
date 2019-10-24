<?php

namespace App\Domains\Form\Http\Controllers\Api;

use App\Http\Response;
use App\Http\Controllers\Controller;
use App\Domains\Form\Models\FormSubmission;
use App\Domains\Form\Http\Resources\FormSubmissionResource;

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
     * @param  \App\Domains\Form\Models\FormSubmission $submission
     * @return \App\Domains\Form\Http\Resources\FormSubmissionResource
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function __invoke(FormSubmission $submission): FormSubmissionResource
    {
        abort_if(is_null($submission->form), Response::HTTP_NOT_FOUND);

        $this->authorize('view-submission', $submission->form);

        return new FormSubmissionResource($submission);
    }
}
