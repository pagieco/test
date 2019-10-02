<?php

namespace App\Http\Controllers\Api\Project;

use App\Http\Response;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;

class SwitchToProjectController extends Controller
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
     * Switch the user to another project.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Models\Project $project
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function __invoke(Request $request, Project $project): JsonResponse
    {
        $this->authorize('switch', $project);

        $request->user()->switchToProject($project);

        return Response::ok();
    }
}
