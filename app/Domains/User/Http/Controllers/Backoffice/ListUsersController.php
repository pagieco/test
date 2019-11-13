<?php

namespace App\Domains\User\Http\Controllers\Backoffice;

use App\Domains\User\Models\User;
use App\Http\Controllers\Controller;

class ListUsersController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct ()
    {
        $this->middleware(['auth', 'backoffice']);
    }

    public function __invoke()
    {
        $users = User::paginate();

        return view( 'backoffice.user.list-users' )->with([
            'users' => $users,
        ]);
    }
}
