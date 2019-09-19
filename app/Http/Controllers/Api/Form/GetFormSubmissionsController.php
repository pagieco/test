<?php

namespace App\Http\Controllers\Api\Form;

use App\Models\Form;
use App\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\FormSubmissionsResource;

class GetFormSubmissionsController extends Controller
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
     * Return a list of form submissions for the given form.
     *
     * @param  \App\Models\Form $form
     * @return \App\Http\Resources\FormSubmissionsResource
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function __invoke(Form $form): FormSubmissionsResource
    {
        $this->authorize('list-submissions', $form);

        $submissions = $form->submissions;

        abort_if($submissions->isEmpty(), Response::HTTP_NO_CONTENT);

        return new FormSubmissionsResource($submissions);
    }
}
