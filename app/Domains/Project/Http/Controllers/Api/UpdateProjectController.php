<?php

namespace App\Domains\Project\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Domains\Project\Models\Project;
use App\Domains\Project\Http\Resources\ProjectResource;
use App\Domains\Project\Http\Requests\UpdateProjectRequest;

class UpdateProjectController extends Controller
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
     * Update the given project.
     *
     * @param  \App\Domains\Project\Http\Requests\UpdateProjectRequest $request
     * @param  \App\Domains\Project\Models\Project $project
     * @return \App\Domains\Project\Http\Resources\ProjectResource
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function __invoke(UpdateProjectRequest $request, Project $project): ProjectResource
    {
        $this->authorize('update', $project);

        $project->update($request->all());

        return new ProjectResource($project);
    }
}
