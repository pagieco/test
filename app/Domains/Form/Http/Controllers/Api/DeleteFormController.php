<?php

namespace App\Domains\Form\Http\Controllers\Api;

use App\Http\Response;
use App\Domains\Form\Models\Form;
use App\Http\Controllers\Controller;

class DeleteFormController extends Controller
{
    /**
     * Create a new form instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Delete the given form.
     *
     * @param  \App\Domains\Form\Models\Form $form
     * @return void
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function __invoke(Form $form): void
    {
        $this->authorize('delete', $form);

        $form->delete();

        abort(Response::HTTP_NO_CONTENT);
    }
}
