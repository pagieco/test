<?php

namespace App\Domains\Form\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Domains\Form\Models\Form;
use App\Http\Controllers\Controller;
use App\Domains\Form\Models\FormField;
use Illuminate\Validation\ValidationException;
use App\Domains\Form\Http\Resources\FormResource;
use App\Domains\Form\Http\Requests\CreateFormRequest;

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
     * @param  \App\Domains\Form\Http\Requests\CreateFormRequest $request
     * @return \App\Domains\Form\Http\Resources\FormResource
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \Illuminate\Validation\ValidationException
     */
    public function __invoke(CreateFormRequest $request): FormResource
    {
        $this->authorize('create', Form::class);

        $form = $this->createForm($request);

        if (! $identifier = $request->getProfileIdentifier()) {
            throw ValidationException::withMessages([
                'profile-identifier' => 'A profile identifier field is required.',
            ]);
        }

        if (count(array_filter(data_get($request->fields, '*.is_profile_identifier'))) > 1) {
            throw ValidationException::withMessages([
                'profile-identifier' => 'Only one profile identifier field can be present per form.',
            ]);
        }

        foreach ($request->fields as $field) {
            $this->createFormField($form, $field);
        }

        return new FormResource($form);
    }

    /**
     * Create a new form.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \App\Domains\Form\Models\Form
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
     * @param  \App\Domains\Form\Models\Form $form
     * @param  array $attributes
     * @return \App\Domains\Form\Models\FormField
     */
    protected function createFormField(Form $form, array $attributes): FormField
    {
        $field = new FormField($attributes);

        $field->form()->associate($form);
        $field->project()->associate($form->project);

        return tap($field)->save();
    }
}
