<?php

namespace App\Domains\Form\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use App\Domains\Form\Models\FormSubmission;
use Illuminate\Notifications\Messages\MailMessage;

class FormSubmissionNotification extends Notification
{
    use Queueable;

    /**
     * The form submission instance.
     *
     * @var \App\Domains\Form\Models\FormSubmission
     */
    protected $submission;

    /**
     * Create a new notification instance.
     *
     * @param  \App\Domains\Form\Models\FormSubmission $submission
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
