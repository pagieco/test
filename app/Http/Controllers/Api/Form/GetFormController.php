<?php

namespace App\Http\Controllers\Api\Form;

use App\Models\Form;
use App\Http\Controllers\Controller;
use App\Http\Resources\FormResource;

class GetFormController extends Controller
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
     * Show the given form.
     *
     * @param  \App\Models\Form $form
     * @return \App\Http\Resources\FormResource
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function __invoke(Form $form): FormResource
    {
        $this->authorize('view', $form);

        return new FormResource($form);
    }
}
