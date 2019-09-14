<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;

    protected $with = ['projects'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getCurrentProjectAttribute()
    {
        return $this->currentProject();
    }

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

    public function currentProject()
    {
        if (is_null($this->current_project_id)) {
            $this->switchToProject($this->projects->first());

            return $this->currentProject();
        } elseif (! is_null($this->current_project_id)) {
            $currentProject = Project::find($this->current_project_id);

            return $currentProject ?: $this->refreshCurrentProject();
        }
    }

    public function switchToProject(Project $project)
    {
        $this->current_project_id = $project->id;

        $this->save();
    }

    protected function refreshCurrentProject()
    {
        $this->current_project_id = null;

        $this->save();

        return $this->currentProject();
    }
}
