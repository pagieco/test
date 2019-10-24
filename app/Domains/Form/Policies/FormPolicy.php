<?php

namespace App\Domains\Form\Policies;

use App\Domains\User\Models\User;
use App\Domains\Form\Models\Form;
use Illuminate\Auth\Access\HandlesAuthorization;

class FormPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can list the forms.
     *
     * @param  \App\Domains\User\Models\User $user
     * @return bool
     */
    public function list(User $user): bool
    {
        return $user->hasAccess('form:list');
    }

    /**
     * Determine whether the user can view the form.
     *
     * @param  \App\Domains\User\Models\User $user
     * @param  \App\Domains\Form\Models\Form $form
     * @return bool
     */
    public function view(User $user, Form $form): bool
    {
        return $user->hasAccess('form:view')
            && $user->currentProject()->forms->contains($form->id);
    }

    /**
     * Determine whether the user can create a new form.
     *
     * @param  \App\Domains\User\Models\User $user
     * @return bool
     */
    public function create(User $user): bool
    {
        return $user->hasAccess('form:create');
    }

    /**
     * Determine whether the user can delete the form.
     *
     * @param  \App\Domains\User\Models\User $user
     * @param  \App\Domains\Form\Models\Form $form
     * @return bool
     */
    public function delete(User $user, Form $form): bool
    {
        return $user->hasAccess('form:delete')
            && $user->currentProject()->forms->contains($form->id);
    }

    /**
     * Determine whether the user can list the form submissions.
     *
     * @param  \App\Domains\User\Models\User $user
     * @param  \App\Domains\Form\Models\Form $form
     * @return bool
     */
    public function listSubmissions(User $user, Form $form): bool
    {
        return $user->hasAccess('form:list-submissions')
            && $user->currentProject()->forms->contains($form->id);
    }

    /**
     * Determine whether the user  can view a form submission.
     *
     * @param  \App\Domains\User\Models\User $user
     * @param  \App\Domains\Form\Models\Form $form
     * @return bool
     */
    public function viewSubmission(User $user, Form $form): bool
    {
        return $user->hasAccess('form:view-submission')
            && $user->currentProject()->forms->contains($form->id);
    }
}
