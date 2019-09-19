<?php

namespace App\Models\Observers;

use App\Models\User;

class UserObserver
{
    /**
     * Listen to the user model "created" event.
     *
     * @param  \App\Models\User $user
     * @return void
     */
    public function created(User $user): void
    {
        $user->projects()->create([
            'name' => 'Personal',
        ]);
    }
}
