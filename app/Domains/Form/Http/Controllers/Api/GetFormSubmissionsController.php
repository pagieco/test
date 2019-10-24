<?php

namespace App\Domains\Form\Http\Controllers\Api;

use App\Http\Response;
use App\Domains\Form\Models\Form;
use App\Http\Controllers\Controller;
use App\Domains\Form\Http\Resources\FormSubmissionsResource;

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
     * @param  \App\Domains\Form\Models\Form $form
     * @return \App\Domains\Form\Http\Resources\FormSubmissionsResource
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
