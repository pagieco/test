<?php

namespace App\Domains\Profile\Observers;

use App\Domains\Profile\Models\ProfileEvent;

class ProfileEventObserver
{
    public function creating(ProfileEvent $event)
    {
        $event->occurred_at = now();
    }
}
