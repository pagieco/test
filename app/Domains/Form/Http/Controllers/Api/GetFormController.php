<?php

namespace App\Domains\Form\Http\Controllers\Api;

use App\Domains\Form\Models\Form;
use App\Http\Controllers\Controller;
use App\Domains\Form\Http\Resources\FormResource;

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
     * @param  \App\Domains\Form\Models\Form $form
     * @return \App\Domains\Form\Http\Resources\FormResource
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function __invoke(Form $form): FormResource
    {
        $this->authorize('view', $form);

        return new FormResource($form);
    }
}
