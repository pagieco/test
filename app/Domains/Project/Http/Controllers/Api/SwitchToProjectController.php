<?php

namespace App\Domains\Project\Http\Controllers\Api;

use App\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Domains\Project\Models\Project;

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
     * @param  \App\Domains\Project\Models\Project $project
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
