<?php

namespace App\Domains\Project\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Domains\Project\Models\Project;
use App\Domains\Project\Http\Resources\ProjectResource;

class GetProjectController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Get a specific project.
     *
     * @param  \App\Domains\Project\Models\Project $project
     * @return \App\Domains\Project\Http\Resources\ProjectResource
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function __invoke(Project $project): ProjectResource
    {
        $this->authorize('view', $project);

        return new ProjectResource($project);
    }
}
