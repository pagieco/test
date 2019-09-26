<?php

namespace App\Http\Controllers\Api\Form;

use App\Models\Form;
use App\Models\FormField;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\FormResource;
use App\Http\Requests\CreateFormRequest;

class CreateFormController extends Controller
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
     * Create a new form from the given request.
     *
     * @param  \App\Http\Requests\CreateFormRequest $request
     * @return \App\Http\Resources\FormResource
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function __invoke(CreateFormRequest $request): FormResource
    {
        $this->authorize('create', Form::class);

        $form = $this->createForm($request);

        foreach ($request->fields as $field) {
            $this->createFormField($form, $field);
        }

        return new FormResource($form);
    }

    /**
     * Create a new form.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \App\Models\Form
     */
    protected function createForm(Request $request): Form
    {
        $form = new Form($request->all());

        $form->project()->associate(
            $request->user()->currentProject()
        );

        return tap($form)->save();
    }

    /**
     * Create a new form field.
     *
     * @param  \App\Models\Form $form
     * @param  array $attributes
     * @return \App\Models\FormField
     */
    protected function createFormField(Form $form, array $attributes): FormField
    {
        $field = new FormField($attributes);

        $field->form()->associate($form);
        $field->project()->associate($form->project);

        return tap($field)->save();
    }
}
