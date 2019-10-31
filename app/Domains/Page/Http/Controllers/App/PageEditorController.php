<?php

namespace App\Domains\Page\Http\Controllers\App;

use App\Domains\Page\Models\Page;
use App\Http\Controllers\Controller;

class PageEditorController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function __invoke(Page $page)
    {
        return view('app.page-designer')->with([
            'project' => $page->project,
            'page' => $page,
        ]);
    }
}
