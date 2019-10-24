<?php

namespace App\Domains\Project\Events;

use App\Domains\User\Models\User;
use Illuminate\Queue\SerializesModels;
use App\Domains\Project\Models\Project;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

class ProjectShared
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * The project instance.
     *
     * @var \App\Domains\Project\Models\Project
     */
    public $project;

    /**
     * The user instance.
     *
     * @var \App\Domains\User\Models\User
     */
    public $user;

    /**
     * Create a new event instance.
     *
     * @param  \App\Domains\Project\Models\Project $project
     * @param  \App\Domains\User\Models\User $user
     */
    public function __construct(Project $project, User $user)
    {
        $this->project = $project;
        $this->user = $user;
    }
}
