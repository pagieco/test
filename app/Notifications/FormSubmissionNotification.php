<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use App\Models\FormSubmission;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class FormSubmissionNotification extends Notification
{
    use Queueable;

    /**
     * The form submission instance.
     *
     * @var \App\Models\FormSubmission
     */
    protected $submission;

    /**
     * Create a new notification instance.
     *
     * @param  \App\Models\FormSubmission $submission
     */
    public function __construct(FormSubmission $submission)
    {
        $this->submission = $submission;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $form = $this->submission->form;

        return (new MailMessage)->subject(sprintf('Form %s submitted.', $form->name));
    }
}
