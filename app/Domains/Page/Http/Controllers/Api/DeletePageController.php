<?php

namespace App\Domains\Page\Http\Controllers\Api;

use App\Http\Response;
use App\Domains\Page\Models\Page;
use App\Http\Controllers\Controller;

class DeletePageController extends Controller
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
     * Delete the given page.
     *
     * @param  \App\Domains\Page\Models\Page $page
     * @return void
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function __invoke(Page $page): void
    {
        $this->authorize('delete', $page);

        $page->delete();

        abort(Response::HTTP_NO_CONTENT);
    }
}
