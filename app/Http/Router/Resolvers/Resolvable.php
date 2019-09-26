<?php

namespace App\Http\Router\Resolvers;

use App\Models\Domain;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;

interface Resolvable
{
    /**
     * Try to resolve the given request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Models\Domain $domain
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public static function resolve(Request $request, Domain $domain = null): ?Model;
}
