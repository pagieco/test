<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Page;
use Illuminate\Auth\Access\HandlesAuthorization;

class PagePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can list the pages.
     *
     * @param  \App\Models\User $user
     * @return bool
     */
    public function list(User $user): bool
    {
        return $user->hasAccess('page:list');
    }

    /**
     * Determine whether the user can view the page.
     *
     * @param  \App\Models\User $user
     * @param  \App\Models\Page $page
     * @return bool
     */
    public function view(User $user, Page $page): bool
    {
        return $user->hasAccess('page:view')
            && $user->currentProject()->pages->contains($page->id);
    }
}
