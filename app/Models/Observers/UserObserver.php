<?php

namespace App\Models\Observers;

use App\Models\User;

class UserObserver
{
    public function created(User $user): void
    {
        $user->projects()->create([
            'name' => 'Personal',
        ]);
    }
}
