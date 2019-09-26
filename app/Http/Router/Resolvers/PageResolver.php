<?php

namespace App\Http\Router\Resolvers;

use App\Models\Domain;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;

class PageResolver implements Resolvable
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
        return $domain->project
            ->pages()
            ->where('slug', $request->path())
            ->first();
    }
}
