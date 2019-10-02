<?php

namespace App\Models\Observers;

use App\Models\FormSubmission;
use App\Notifications\FormSubmissionNotification;

class FormSubmissionObserver
{
    public function created(FormSubmission $submission)
    {
        foreach ($submission->form->subscribers as $subscriber) {
            $subscriber->notify(new FormSubmissionNotification($submission));
        }
    }
}
