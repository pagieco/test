<?php

namespace App\Http\Controllers\Api\Form;

use App\Models\Form;
use App\Http\Response;
use App\Models\Profile;
use App\Models\FormField;
use Illuminate\Http\Request;
use App\Models\FormSubmission;
use App\Http\Controllers\Controller;
use App\Http\Requests\SubmitFormRequest;
use App\Http\Resources\FormSubmissionResource;

class SubmitFormController extends Controller
{
    /**
     * Handle the form submission.
     *
     * @param  \App\Http\Requests\SubmitFormRequest $request
     * @param  \App\Models\Form $form
     * @return \App\Http\Resources\FormSubmissionResource
     */
    public function __invoke(SubmitFormRequest $request, Form $form)
    {
        // Abort the request when the given signature in the request is invalid or there is no signature at all.
        abort_if(! $request->hasValidSignature(), Response::HTTP_NOT_ACCEPTABLE);

        // Abort the request when there are no form fields present in the current form.
        abort_if($form->fields->isEmpty(), Response::HTTP_BAD_REQUEST);

        $request->validate($this->validatorData($form));

        $submission = $this->insertSubmission($request, $form);

        return new FormSubmissionResource($submission);
    }

    /**
     * Create the validator data.
     *
     * @param  \App\Models\Form $form
     * @return array
     */
    protected function validatorData(Form $form): array
    {
        return (array) $form->fields->mapWithKeys(function (FormField $field): array {
            $key = sprintf('fields.%s', $field->slug);

            return [$key => $field->validations];
        });
    }

    /**
     * Create a new form-submission.
     *
     * @param  \App\Http\Requests\SubmitFormRequest $request
     * @param  \App\Models\Form $form
     * @return \App\Models\FormSubmission
     */
    protected function insertSubmission(SubmitFormRequest $request, Form $form): FormSubmission
    {
        $submission = new FormSubmission([
            'submission_data' => $request->get('fields'),
        ]);

        if ($profile = $this->identifyProfile($request, $form)) {
            $submission->profile()->associate($profile);
        }

        $submission->form()->associate($form);
        $submission->project()->associate($form->project);

        return tap($submission)->save();
    }

    protected function identifyProfile(Request $request, Form $form)
    {
        $idField = $form->getProfileIdentifierField();

        $email = $request->fields[$idField->slug];

        if (! $profile = Profile::byEmail($email)->first()) {
            $profile = new Profile([
                'email' => $email,
            ]);

            $profile->project()->associate($form->project);
            $profile->save();
        }

        return $profile;
    }
}
