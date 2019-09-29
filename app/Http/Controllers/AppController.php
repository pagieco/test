<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;

class AppController extends Controller
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
     * Render the app view.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\View\View
     */
    public function __invoke(Request $request): View
    {
        return view('app', [
            'appConfig' => [
                'app' => [
                    'title' => config('app.name'),
                ],
                'user' => (new UserResource($request->user()))->toArray($request),
                'project' => $request->user()->currentProject,
            ],
        ]);
    }
}
