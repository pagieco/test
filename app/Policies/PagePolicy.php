<?php

namespace App\Policies;

use App\Models\Page;
use App\Models\User;
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

    /**
     * Determine whether the user can create a new page.
     *
     * @param  \App\Models\User $user
     * @return bool
     */
    public function create(User $user): bool
    {
        return $user->hasAccess('page:create');
    }

    /**
     * Determine whether the user can update the page.
     *
     * @param  \App\Models\User $user
     * @param  \App\Models\Page $page
     * @return bool
     */
    public function update(User $user, Page $page): bool
    {
        return $user->hasAccess('page:update')
            && $user->currentProject()->pages->contains($page->id);
    }

    /**
     * Determine whether the user can delete the page.
     *
     * @param  \App\Models\User $user
     * @param  \App\Models\Page $page
     * @return bool
     */
    public function delete(User $user, Page $page): bool
    {
        return $user->hasAccess('page:delete')
            && $user->currentProject()->pages->contains($page->id);
    }

    /**
     * Determine whether the user can publish the page.
     *
     * @param  \App\Models\User $user
     * @param  \App\Models\Page $page
     * @return bool
     */
    public function publish(User $user, Page $page): bool
    {
        return $user->hasAccess('page:publish')
            && $user->currentProject()->pages->contains($page->id);
    }
}
