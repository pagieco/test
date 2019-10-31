<?php

namespace App\Domains\Collection\Http\Controllers\App;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CollectionEditorController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function __invoke(Request $request)
    {
        return view('app.collection-editor')->with([
            'project' => $request->user()->currentProject,
        ]);
    }
}
