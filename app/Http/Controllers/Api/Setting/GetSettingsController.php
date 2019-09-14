<?php

namespace App\Http\Controllers\Api\Setting;

use App\Http\Controllers\Controller;

class GetSettingsController extends Controller
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
