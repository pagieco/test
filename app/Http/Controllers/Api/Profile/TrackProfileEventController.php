<?php

namespace App\Http\Controllers\Api\Profile;

use App\Http\Controllers\Controller;

class TrackProfileEventController extends Controller
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
    }
}
