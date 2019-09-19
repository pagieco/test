<?php

namespace App\Models\Traits;

use App\Models\Project;
use App\Models\Collaborator;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

trait InteractsWithProjects
{
    /**
     * All of the projects that belong to the user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function projects(): HasMany
    {
        return $this->hasMany(Project::class);
    }

    /**
     * Get the current project attribute.
     *
     * @return \App\Models\Project
     */
    public function getCurrentProjectAttribute()
    {
        return $this->currentProject();
    }

    /**
     * All of the projects that have been shared with the user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function teamProjects(): BelongsToMany
    {
        return $this->belongsToMany(Project::class, 'project_user')->using(Collaborator::class);
    }

    /**
     * Determine if the user has access to the given project.
     *
     * @param  \App\Models\Project $project
     * @return bool
     */
    public function canAccessProject(Project $project): bool
    {
        return $this->projects->contains($project)
            || $this->teamProjects->contains($project);
    }

    /**
     * Get the project that the user is currently viewing.
     *
     * @return \App\Models\Project
     */
    public function currentProject(): Project
    {
        if (is_null($this->current_project_id)) {
            $this->switchToProject($this->projects->first());

            return $this->currentProject();
        } elseif (! is_null($this->current_project_id)) {
            $currentProject = Project::find($this->current_project_id);

            return $currentProject ?: $this->refreshCurrentProject();
        }
    }

    /**
     * Switch the current project for the user.
     *
     * @param  \App\Models\Project $project
     * @return void
     */
    public function switchToProject(Project $project)
    {
        $this->current_project_id = $project->id;

        $this->save();
    }

    /**
     * Refresh the current project for the user.
     *
     * @return \App\Models\Project
     */
    protected function refreshCurrentProject(): Project
    {
        $this->current_project_id = null;

        $this->save();

        return $this->currentProject();
    }
}
