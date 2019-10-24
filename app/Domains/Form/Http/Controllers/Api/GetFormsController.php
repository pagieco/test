<?php

namespace App\Domains\Form\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Domains\Form\Models\Form;
use App\Http\Controllers\Controller;
use App\Domains\Form\Http\Resources\FormsResource;

class GetFormsController extends Controller
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
     * Return a list of forms from the current project.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \App\Domains\Form\Http\Resources\FormsResource
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function __invoke(Request $request): FormsResource
    {
        $this->authorize('list', Form::class);

        $forms = $request->user()->currentProject()->forms;

        abort_if($forms->isEmpty(), Response::HTTP_NO_CONTENT);

        return new FormsResource($forms);
    }
}
