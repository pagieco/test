<?php

namespace App\Http\Controllers\Api\Page;

use App\Http\Controllers\Controller;

class CreatePageController extends Controller
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

    public function __invoke()
    {
        // TODO: Implement __invoke() method.
    }
}
