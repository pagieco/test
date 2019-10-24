<?php

namespace App\Domains\Form\Observers;

use App\Domains\Form\Models\FormSubmission;
use App\Domains\Form\Notifications\FormSubmissionNotification;

class FormSubmissionObserver
{
    public function created(FormSubmission $submission)
    {
        foreach ($submission->form->subscribers as $subscriber) {
            $subscriber->notify(new FormSubmissionNotification($submission));
        }
    }
}
