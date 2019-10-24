<?php

namespace App\Domains\Profile\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Domains\Profile\Models\Profile;

class ProfileConsentMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * The profile instance.
     *
     * @var \App\Domains\Profile\Models\Profile
     */
    public $profile;

    /**
     * Create a new message instance.
     *
     * @param  \App\Domains\Profile\Models\Profile $profile
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
