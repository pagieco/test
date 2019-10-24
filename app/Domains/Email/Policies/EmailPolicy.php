<?php

namespace App\Domains\Email\Policies;

use App\Domains\User\Models\User;
use App\Domains\Email\Models\Email;
use Illuminate\Auth\Access\HandlesAuthorization;

class EmailPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can list the emails.
     *
     * @param  \App\Domains\User\Models\User $user
     * @return bool
     */
    public function list(User $user): bool
    {
        return $user->hasAccess('email:list');
    }

    /**
     * Determine whether the user can view the email.
     *
     * @param  \App\Domains\User\Models\User $user
     * @param  \App\Domains\Email\Models\Email $email
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
     * @param  \App\Domains\User\Models\User $user
     * @return bool
     */
    public function create(User $user): bool
    {
        return $user->hasAccess('email:create');
    }

    /**
     * Determine whether the user can update the email.
     *
     * @param  \App\Domains\User\Models\User $user
     * @param  \App\Domains\Email\Models\Email $email
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
     * @param  \App\Domains\User\Models\User $user
     * @param  \App\Domains\Email\Models\Email $email
     * @return bool
     */
    public function delete(User $user, Email $email): bool
    {
        return $user->hasAccess('email:delete')
            && $user->currentProject()->emails->contains($email->id);
    }
}
