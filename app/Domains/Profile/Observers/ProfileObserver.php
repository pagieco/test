<?php

namespace App\Domains\Profile\Observers;

use Illuminate\Support\Str;
use App\Domains\Profile\Models\Profile;

class ProfileObserver
{
    /**
     * Listen to the profile model "creating" event.
     *
     * @param  \App\Domains\Profile\Models\Profile $profile
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
