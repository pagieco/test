<?php

namespace App\Macros;

use Closure;

class RequestMixin
{
    /**
     * Determine that the current request is an api request.
     *
     * @return \Closure
     */
    public function isApiRoute(): Closure
    {
        return function (): bool {
            return $this->segment(1) === 'api';
        };
    }
}
