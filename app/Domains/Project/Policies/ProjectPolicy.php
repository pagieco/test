<?php

namespace App\Domains\Project\Policies;

use App\Domains\User\Models\User;
use App\Domains\Project\Models\Project;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProjectPolicy
{
    use HandlesAuthorization;

    public function view(User $user, Project $project): bool
    {
        return $user->hasAccess('project:view')
            && $user->canAccessProject($project);
    }

    /**
     * Determine whether the user can switch to the project.
     *
     * @param  \App\Domains\User\Models\User $user
     * @param  \App\Domains\Project\Models\Project $project
     * @return bool
     */
    public function switch(User $user, Project $project): bool
    {
        return $user->hasAccess('project:switch')
            && $user->canAccessProject($project);
    }

    /**
     * Determine whether the user can update the project.
     *
     * @param  \App\Domains\User\Models\User $user
     * @param  \App\Domains\Project\Models\Project $project
     * @return bool
     */
    public function update(User $user, Project $project): bool
    {
        return $user->hasAccess('project:update')
            && $user->canAccessProject($project);
    }
}
