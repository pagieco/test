<?php

namespace App\Models\Repositories;

use App\Models\Collection;
use App\Models\QueryBuilders\CollectionEntryQueryBuilder;

class CollectionRepository
{
    public function filtered(Collection $collection)
    {
        return (new CollectionEntryQueryBuilder)
            ->build($collection)
            ->get();
    }
}
