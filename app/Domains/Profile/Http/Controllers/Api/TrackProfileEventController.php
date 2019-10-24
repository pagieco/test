<?php

namespace App\Domains\Profile\Http\Controllers\Api;

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
