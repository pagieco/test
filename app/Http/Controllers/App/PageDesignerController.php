<?php

namespace App\Http\Controllers\App;

use App\Models\Page;
use App\Http\Controllers\Controller;

class PageDesignerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function __invoke(Page $page)
    {
        return view('app.page-designer')->with(['page' => $page]);
    }
}
