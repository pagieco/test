<?php

namespace App\Domains\User\Http\Controllers\Backoffice;

use App\Domains\User\Models\User;
use App\Http\Controllers\Controller;

class ShowUserController extends Controller {

    /**
     * Construct a new controller instance.
     *
     * @return void
     */
    public function __construct () {
        $this->middleware( [ 'auth', 'backoffice' ] );
    }

    public function __invoke ( User $user ) {
        return view( 'backoffice.user.show-user' )->with(
            [
                'user' => $user,
            ]
        );
    }
}
