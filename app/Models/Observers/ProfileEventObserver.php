<?php

namespace App\Models\Observers;

use App\Models\ProfileEvent;

class ProfileEventObserver
{
    public function creating(ProfileEvent $event)
    {
        $event->occurred_at = now();
    }
}
