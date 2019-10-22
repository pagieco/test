<?php

namespace App\Models\Repositories;

use App\Models\Profile;
use Spatie\QueryBuilder\AllowedSort;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ProfileRepository
{
    /**
     * Get all profiles.
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function all(): LengthAwarePaginator
    {
        return QueryBuilder::for(Profile::class)
            ->where('project_id', auth()->user()->current_project_id)
            ->defaultSort('-last_seen_at')
            ->allowedSorts([
                'email',
                'last_seen_at',
                'first_seen_at',
                AllowedSort::field('id', 'local_id'),
            ])
            ->allowedFilters(['profile_id', 'email'])
            ->jsonPaginate();
    }
}
