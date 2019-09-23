<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Email;
use Illuminate\Auth\Access\HandlesAuthorization;

class EmailPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can list the emails.
     *
     * @param  \App\Models\User $user
     * @return bool
     */
    public function list(User $user): bool
    {
        return $user->hasAccess('email:list');
    }

    /**
     * Determine whether the user can view the email.
     *
     * @param  \App\Models\User $user
     * @param  \App\Models\Email $email
     * @return bool
     */
    public function view(User $user, Email $email): bool
    {
        return $user->hasAccess('email:view')
            && $user->currentProject()->emails->contains($email->id);
    }

    /**
     * Determine whether the user can create a new email.
     *
     * @param  \App\Models\User $user
     * @return bool
     */
    public function create(User $user): bool
    {
        return $user->hasAccess('email:create');
    }

    /**
     * Determine whether the user can update the email.
     *
     * @param  \App\Models\User $user
     * @param  \App\Models\Email $email
     * @return bool
     */
    public function update(User $user, Email $email): bool
    {
        return $user->hasAccess('email:update')
            && $user->currentProject()->emails->contains($email->id);
    }

    /**
     * Determine whether the user can delete the email.
     *
     * @param  \App\Models\User $user
     * @param  \App\Models\Email $email
     * @return bool
     */
    public function delete(User $user, Email $email): bool
    {
        return $user->hasAccess('email:delete')
            && $user->currentProject()->emails->contains($email->id);
    }
}
