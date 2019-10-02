<?php

namespace App\Http\Controllers\Api\Project;

use App\Models\Project;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProjectResource;
use App\Http\Requests\UpdateProjectRequest;

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
     * @param  \App\Http\Requests\UpdateProjectRequest $request
     * @param  \App\Models\Project $project
     * @return \App\Http\Resources\ProjectResource
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function __invoke(UpdateProjectRequest $request, Project $project): ProjectResource
    {
        $this->authorize('update', $project);

        $project->update($request->all());

        return new ProjectResource($project);
    }
}
