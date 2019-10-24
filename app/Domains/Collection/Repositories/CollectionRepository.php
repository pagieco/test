<?php

namespace App\Domains\Collection\Repositories;

use App\Domains\Collection\Models\Collection;
use App\Domains\Collection\QueryBuilders\CollectionEntryQueryBuilder;

class CollectionRepository
{
    public function filtered(Collection $collection)
    {
        return (new CollectionEntryQueryBuilder)
            ->build($collection)
            ->get();
    }
}
