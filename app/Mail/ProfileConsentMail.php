<?php

namespace App\Mail;

use App\Models\Profile;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ProfileConsentMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * The profile instance.
     *
     * @var \App\Models\Profile
     */
    public $profile;

    /**
     * Create a new message instance.
     *
     * @param  \App\Models\Profile $profile
     * @return void
     */
    public function __construct(Profile $profile)
    {
        $this->profile = $profile;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mails.profile-consent', [
            'profile' => $this->profile,
        ]);
    }
}
