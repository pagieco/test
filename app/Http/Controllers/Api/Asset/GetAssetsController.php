<?php

namespace App\Http\Controllers\Api\Assets;

use App\Http\Controllers\Controller;

class GetAssetsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function __invoke()
    {
        $this->authorize('list', Asset);
    }
}