<?php

namespace App\Domains\User\Observers;

use App\Domains\User\Models\User;

class UserObserver
{
    /**
     * Listen to the user model "created" event.
     *
     * @param  \App\Domains\User\Models\User $user
     * @return void
     */
    public function created(User $user): void
    {
        $user->projects()->create([
            'name' => 'Personal',
        ]);
    }
}
