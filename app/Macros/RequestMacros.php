<?php

namespace App\Macros;

use Illuminate\Http\Request;

class RequestMacros
{
    public function isApiRoute()
    {
        return function () {
            return $this->segment(1) === 'api';
        };
    }
}