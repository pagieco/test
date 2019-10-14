<?php

namespace App\Models\Observers;

use App\Models\Profile;
use Illuminate\Support\Str;

class ProfileObserver
{
    /**
     * Listen to the profile model "creating" event.
     *
     * @param  \App\Models\Profile $profile
     * @return void
     */
    public function creating(Profile $profile): void
    {
        $profile->first_seen_at = now();

        if (! $profile->profile_id) {
            $profile->setAttribute('profile_id', Str::uuid());
        }
    }

    public function created(Profile $profile): void
    {
        $profile->sendConsentConfirmationEmail();
    }
}
