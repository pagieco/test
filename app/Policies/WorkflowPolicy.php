<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Workflow;
use Illuminate\Auth\Access\HandlesAuthorization;

class WorkflowPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can list the workflows.
     *
     * @param  \App\Models\User $user
     * @return bool
     */
    public function list(User $user): bool
    {
        return $user->hasAccess('workflow:list');
    }

    /**
     * Determine whether the user can view the workflow.
     *
     * @param  \App\Models\User $user
     * @param  \App\Models\Workflow $workflow
     * @return bool
     */
    public function view(User $user, Workflow $workflow): bool
    {
        return $user->hasAccess('workflow:view')
            && $user->currentProject()->workflows->contains($workflow->id);
    }
}
