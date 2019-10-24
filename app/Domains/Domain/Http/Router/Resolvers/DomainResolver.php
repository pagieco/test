<?php

namespace App\Domains\Domain\Http\Router\Resolvers;

use Illuminate\Http\Request;
use App\Domains\Domain\Models\Domain;
use Illuminate\Database\Eloquent\Model;
use App\Http\Router\Resolvers\Resolvable;

class DomainResolver implements Resolvable
{
    /**
     * Try to resolve the given request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Domains\Domain\Models\Domain $domain
     * @return mixed
     */
    public static function resolve(Request $request, Domain $domain = null): ?Model
    {
        return Domain::where('domain_name', $request->getHost())->firstOrFail();
    }
}
