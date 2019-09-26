<?php

namespace App\Http\Router\Resolvers;

use App\Models\Domain;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;

class DomainResolver implements Resolvable
{
    /**
     * Try to resolve the given request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Models\Domain $domain
     * @return mixed
     */
    public static function resolve(Request $request, Domain $domain = null): ?Model
    {
        return Domain::where('domain_name', $request->getHost())->firstOrFail();
    }
}
